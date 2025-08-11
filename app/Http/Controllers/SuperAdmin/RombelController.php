<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RombelController extends Controller
{
    /**
     * Display the rombel management page.
     */
    public function index()
    {
        $academicYears = SchoolClass::distinct()->pluck('academic_year')->sort();
        $currentAcademicYear = $academicYears->last() ?? date('Y') . '/' . (date('Y') + 1);
        
        // Get classes grouped by grade level
        $classesByGrade = SchoolClass::where('academic_year', $currentAcademicYear)
                                   ->orderBy('grade_level')
                                   ->orderBy('section')
                                   ->get()
                                   ->groupBy('grade_level');

        // Get student statistics
        $studentStats = [];
        for ($grade = 1; $grade <= 6; $grade++) {
            $studentStats[$grade] = [
                'total' => Student::byGradeLevel($grade)
                                 ->where('academic_year', $currentAcademicYear)
                                 ->active()
                                 ->count(),
                'repeating' => Student::byGradeLevel($grade)
                                    ->where('academic_year', $currentAcademicYear)
                                    ->repeating()
                                    ->count(),
            ];
        }

        return view('superadmin.rombel.index', compact(
            'classesByGrade', 
            'academicYears', 
            'currentAcademicYear',
            'studentStats'
        ));
    }

    /**
     * Show the form for creating new rombel for all grades.
     */
    public function create()
    {
        $teachers = Staff::where('position', 'like', '%guru%')
                        ->orWhere('position', 'like', '%teacher%')
                        ->pluck('name', 'id');
        
        $academicYears = SchoolClass::distinct()->pluck('academic_year')->sort();
        $nextAcademicYear = $this->generateNextAcademicYear();

        return view('superadmin.rombel.create', compact('teachers', 'academicYears', 'nextAcademicYear'));
    }

    /**
     * Store new rombel for all grades.
     */
    public function store(Request $request)
    {
        $request->validate([
            'academic_year' => 'required|string',
            'curriculum' => 'required|string',
            'classes_per_grade' => 'required|array',
            'classes_per_grade.*' => 'required|integer|min:1|max:5',
            'capacity_per_class' => 'required|integer|min:20|max:40',
        ]);

        DB::beginTransaction();
        
        try {
            $createdClasses = [];
            $sections = ['A', 'B', 'C', 'D', 'E'];

            // Create classes for each grade (1-6)
            for ($grade = 1; $grade <= 6; $grade++) {
                $classCount = $request->classes_per_grade[$grade] ?? 1;
                
                for ($i = 0; $i < $classCount; $i++) {
                    $section = $sections[$i];
                    $className = $grade . $section;

                    // Check if class already exists
                    $existingClass = SchoolClass::where('name', $className)
                                               ->where('academic_year', $request->academic_year)
                                               ->first();

                    if (!$existingClass) {
                        $class = SchoolClass::create([
                            'name' => $className,
                            'grade_level' => $grade,
                            'section' => $section,
                            'capacity' => $request->capacity_per_class,
                            'current_students' => 0,
                            'academic_year' => $request->academic_year,
                            'description' => "Kelas {$className} - {$request->curriculum}",
                            'status' => 'active'
                        ]);

                        $createdClasses[] = $class;
                    }
                }
            }

            DB::commit();

            return redirect()->route('superadmin.rombel.index')
                           ->with('success', 'Rombel berhasil dibuat untuk ' . count($createdClasses) . ' kelas!');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error creating rombel: ' . $e->getMessage());
            
            return back()->withErrors(['error' => 'Gagal membuat rombel: ' . $e->getMessage()])
                        ->withInput();
        }
    }

    /**
     * Show the promotion page.
     */
    public function promotion()
    {
        $academicYears = SchoolClass::distinct()->pluck('academic_year')->sort();
        $currentAcademicYear = $academicYears->last() ?? date('Y') . '/' . (date('Y') + 1);
        $nextAcademicYear = $this->generateNextAcademicYear($currentAcademicYear);

        // Get students by grade for current academic year
        $studentsByGrade = [];
        for ($grade = 1; $grade <= 6; $grade++) {
            $students = Student::byGradeLevel($grade)
                             ->where('academic_year', $currentAcademicYear)
                             ->active()
                             ->with('schoolClass')
                             ->get();
            
            $studentsByGrade[$grade] = $students;
        }

        // Get available classes for next academic year
        $nextYearClasses = SchoolClass::where('academic_year', $nextAcademicYear)
                                    ->orderBy('grade_level')
                                    ->orderBy('section')
                                    ->get()
                                    ->groupBy('grade_level');

        return view('superadmin.rombel.promotion', compact(
            'studentsByGrade',
            'nextYearClasses',
            'currentAcademicYear',
            'nextAcademicYear'
        ));
    }

    /**
     * Process student promotion.
     */
    public function processPromotion(Request $request)
    {
        $request->validate([
            'current_academic_year' => 'required|string',
            'next_academic_year' => 'required|string',
            'promotions' => 'required|array',
            'promotions.*.student_id' => 'required|exists:students,id',
            'promotions.*.action' => 'required|in:promote,repeat,graduate',
            'promotions.*.new_class' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $promoted = 0;
            $repeated = 0;
            $graduated = 0;

            foreach ($request->promotions as $promotion) {
                $student = Student::find($promotion['student_id']);
                
                switch ($promotion['action']) {
                    case 'promote':
                        $this->promoteStudent($student, $promotion['new_class'], $request->next_academic_year);
                        $promoted++;
                        break;
                        
                    case 'repeat':
                        $this->repeatStudent($student, $request->next_academic_year);
                        $repeated++;
                        break;
                        
                    case 'graduate':
                        $this->graduateStudent($student);
                        $graduated++;
                        break;
                }
            }

            // Update class student counts
            $this->updateAllClassCounts($request->next_academic_year);

            DB::commit();

            return redirect()->route('superadmin.rombel.promotion')
                           ->with('success', "Promosi berhasil! Naik kelas: {$promoted}, Mengulang: {$repeated}, Lulus: {$graduated}");

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error processing promotion: ' . $e->getMessage());
            
            return back()->withErrors(['error' => 'Gagal memproses promosi: ' . $e->getMessage()]);
        }
    }

    /**
     * Auto promote students based on grade level.
     */
    public function autoPromotion(Request $request)
    {
        $request->validate([
            'current_academic_year' => 'required|string',
            'next_academic_year' => 'required|string',
            'grade_levels' => 'required|array',
            'grade_levels.*' => 'integer|min:1|max:6',
        ]);

        DB::beginTransaction();

        try {
            $promoted = 0;
            $graduated = 0;

            foreach ($request->grade_levels as $gradeLevel) {
                $students = Student::byGradeLevel($gradeLevel)
                                 ->where('academic_year', $request->current_academic_year)
                                 ->active()
                                 ->where('is_repeating', false)
                                 ->get();

                foreach ($students as $student) {
                    if ($gradeLevel == 6) {
                        // Graduate grade 6 students
                        $this->graduateStudent($student);
                        $graduated++;
                    } else {
                        // Promote to next grade
                        $nextGrade = $gradeLevel + 1;
                        $availableClass = $this->findAvailableClass($nextGrade, $request->next_academic_year);
                        
                        if ($availableClass) {
                            $this->promoteStudent($student, $availableClass->name, $request->next_academic_year);
                            $promoted++;
                        }
                    }
                }
            }

            // Update class student counts
            $this->updateAllClassCounts($request->next_academic_year);

            DB::commit();

            return redirect()->route('superadmin.rombel.promotion')
                           ->with('success', "Auto promosi berhasil! Naik kelas: {$promoted}, Lulus: {$graduated}");

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error in auto promotion: ' . $e->getMessage());
            
            return back()->withErrors(['error' => 'Gagal melakukan auto promosi: ' . $e->getMessage()]);
        }
    }

    /**
     * Promote a student to next class.
     */
    private function promoteStudent($student, $newClass, $academicYear)
    {
        $student->update([
            'class_level' => $newClass,
            'academic_year' => $academicYear,
            'is_repeating' => false,
            'promotion_status' => 'promoted',
        ]);
    }

    /**
     * Mark student as repeating.
     */
    private function repeatStudent($student, $academicYear)
    {
        $student->update([
            'academic_year' => $academicYear,
            'is_repeating' => true,
            'promotion_status' => 'repeating',
        ]);
    }

    /**
     * Graduate a student.
     */
    private function graduateStudent($student)
    {
        $student->update([
            'status' => 'graduated',
            'promotion_status' => 'graduated',
        ]);
    }

    /**
     * Find available class for grade level.
     */
    private function findAvailableClass($gradeLevel, $academicYear)
    {
        return SchoolClass::where('grade_level', $gradeLevel)
                         ->where('academic_year', $academicYear)
                         ->where('status', 'active')
                         ->whereRaw('current_students < capacity')
                         ->orderBy('current_students')
                         ->first();
    }

    /**
     * Update student counts for all classes.
     */
    private function updateAllClassCounts($academicYear)
    {
        $classes = SchoolClass::where('academic_year', $academicYear)->get();
        
        foreach ($classes as $class) {
            $class->updateStudentCount();
        }
    }

    /**
     * Generate next academic year.
     */
    private function generateNextAcademicYear($currentYear = null)
    {
        if (!$currentYear) {
            $currentYear = date('Y') . '/' . (date('Y') + 1);
        }
        
        $years = explode('/', $currentYear);
        $nextStartYear = (int)$years[0] + 1;
        $nextEndYear = (int)$years[1] + 1;
        
        return $nextStartYear . '/' . $nextEndYear;
    }
}
