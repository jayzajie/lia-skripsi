<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Evaluation;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Evaluation::with(['student', 'subject']);
        
        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('student', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhereHas('subject', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }
        
        // Filter by student
        if ($request->has('student_id') && $request->student_id != '') {
            $query->where('student_id', $request->student_id);
        }
        
        // Filter by subject
        if ($request->has('subject_id') && $request->subject_id != '') {
            $query->where('subject_id', $request->subject_id);
        }
        
        // Filter by academic year
        if ($request->has('academic_year') && $request->academic_year != '') {
            $query->where('academic_year', $request->academic_year);
        }
        
        // Filter by semester
        if ($request->has('semester') && $request->semester != '') {
            $query->where('semester', $request->semester);
        }
        
        // Sort
        $sortField = $request->input('sort', 'created_at');
        $sortDirection = $request->input('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);
        
        $evaluations = $query->paginate(10)->withQueryString();
        $students = Student::orderBy('name')->get();
        $subjects = Subject::orderBy('name')->get();
        
        // Get unique academic years and semesters for filtering
        $academicYears = Evaluation::distinct()->pluck('academic_year');
        $semesters = Evaluation::distinct()->pluck('semester');
        
        return view('superadmin.evaluations.index', compact(
            'evaluations', 
            'students', 
            'subjects', 
            'academicYears', 
            'semesters'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = Student::orderBy('name')->get();
        $subjects = Subject::where('status', 'active')->orderBy('name')->get();
        
        return view('superadmin.evaluations.create', compact('students', 'subjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'semester' => 'required|string|max:50',
            'academic_year' => 'required|string|max:50',
            'assessment_score' => 'nullable|numeric|min:0|max:100',
            'mid_exam_score' => 'nullable|numeric|min:0|max:100',
            'final_exam_score' => 'nullable|numeric|min:0|max:100',
            'teacher_notes' => 'nullable|string',
        ]);
        
        // Check for duplicate entries
        $exists = Evaluation::where('student_id', $validated['student_id'])
            ->where('subject_id', $validated['subject_id'])
            ->where('semester', $validated['semester'])
            ->where('academic_year', $validated['academic_year'])
            ->exists();
            
        if ($exists) {
            return redirect()->back()->withInput()
                ->with('error', 'Penilaian untuk siswa, mata pelajaran, semester, dan tahun ajaran ini sudah ada');
        }
        
        // Calculate final score and grade if all component scores are provided
        if (isset($validated['assessment_score']) && isset($validated['mid_exam_score']) && isset($validated['final_exam_score'])) {
            $evaluation = new Evaluation();
            $evaluation->fill($validated);
            
            $finalScore = $evaluation->calculateFinalScore();
            $grade = $evaluation->determineGrade($finalScore);
            
            $validated['final_score'] = $finalScore;
            $validated['grade'] = $grade;
        }
        
        // Create evaluation
        $evaluation = Evaluation::create($validated);
        
        return redirect()->route('superadmin.evaluations.index')
            ->with('success', 'Penilaian berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Evaluation $evaluation)
    {
        $evaluation->load('student', 'subject');
        return view('superadmin.evaluations.show', compact('evaluation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Evaluation $evaluation)
    {
        $students = Student::orderBy('name')->get();
        $subjects = Subject::orderBy('name')->get();
        
        return view('superadmin.evaluations.edit', compact('evaluation', 'students', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Evaluation $evaluation)
    {
        $validated = $request->validate([
            'student_id' => [
                'required', 
                'exists:students,id',
                Rule::unique('evaluations', 'student_id')->where(function ($query) use ($request, $evaluation) {
                    return $query->where('subject_id', $request->subject_id)
                                ->where('semester', $request->semester)
                                ->where('academic_year', $request->academic_year);
                })->ignore($evaluation->id)
            ],
            'subject_id' => 'required|exists:subjects,id',
            'semester' => 'required|string|max:50',
            'academic_year' => 'required|string|max:50',
            'assessment_score' => 'nullable|numeric|min:0|max:100',
            'mid_exam_score' => 'nullable|numeric|min:0|max:100',
            'final_exam_score' => 'nullable|numeric|min:0|max:100',
            'teacher_notes' => 'nullable|string',
        ]);
        
        // Calculate final score and grade if all component scores are provided
        if (isset($validated['assessment_score']) && isset($validated['mid_exam_score']) && isset($validated['final_exam_score'])) {
            $tempEvaluation = new Evaluation();
            $tempEvaluation->assessment_score = $validated['assessment_score'];
            $tempEvaluation->mid_exam_score = $validated['mid_exam_score'];
            $tempEvaluation->final_exam_score = $validated['final_exam_score'];
            
            $finalScore = $tempEvaluation->calculateFinalScore();
            $grade = $tempEvaluation->determineGrade($finalScore);
            
            $validated['final_score'] = $finalScore;
            $validated['grade'] = $grade;
        }
        
        // Update evaluation
        $evaluation->update($validated);
        
        return redirect()->route('superadmin.evaluations.index')
            ->with('success', 'Penilaian berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Evaluation $evaluation)
    {
        $evaluation->delete();
        
        return redirect()->route('superadmin.evaluations.index')
            ->with('success', 'Penilaian berhasil dihapus');
    }
    
    /**
     * Generate report for a student.
     */
    public function studentReport(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'academic_year' => 'required|string',
            'semester' => 'required|string',
        ]);
        
        $student = Student::findOrFail($validated['student_id']);
        
        $evaluations = Evaluation::with('subject')
            ->where('student_id', $validated['student_id'])
            ->where('academic_year', $validated['academic_year'])
            ->where('semester', $validated['semester'])
            ->get();
            
        // Calculate average scores
        $averageAssessment = $evaluations->avg('assessment_score');
        $averageMidExam = $evaluations->avg('mid_exam_score');
        $averageFinalExam = $evaluations->avg('final_exam_score');
        $averageFinal = $evaluations->avg('final_score');
        
        return view('superadmin.evaluations.report', compact(
            'student', 
            'evaluations', 
            'averageAssessment', 
            'averageMidExam', 
            'averageFinalExam', 
            'averageFinal'
        ));
    }
    
    /**
     * Generate report for a class.
     */
    public function classReport(Request $request)
    {
        $validated = $request->validate([
            'class_level' => 'required|string',
            'academic_year' => 'required|string',
            'semester' => 'required|string',
            'subject_id' => 'nullable|exists:subjects,id',
        ]);
        
        $students = Student::where('class_level', $validated['class_level'])->get();
        $studentIds = $students->pluck('id');
        
        $query = Evaluation::with(['student', 'subject'])
            ->whereIn('student_id', $studentIds)
            ->where('academic_year', $validated['academic_year'])
            ->where('semester', $validated['semester']);
            
        if (isset($validated['subject_id'])) {
            $query->where('subject_id', $validated['subject_id']);
            $subject = Subject::findOrFail($validated['subject_id']);
        }
        
        $evaluations = $query->get();
        
        // Group evaluations by student
        $groupedEvaluations = $evaluations->groupBy('student_id');
        
        return view('superadmin.evaluations.class-report', compact(
            'students', 
            'groupedEvaluations', 
            'subject',
            'evaluations'
        ));
    }
}
