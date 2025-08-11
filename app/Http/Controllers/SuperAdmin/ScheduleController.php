<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Subject;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Database\QueryException;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Schedule::with(['subject', 'teacher']);
        
        // Filter by day
        if ($request->has('day_of_week') && $request->day_of_week != '') {
            $query->where('day_of_week', $request->day_of_week);
        }
        
        // Filter by class level
        if ($request->has('class_level') && $request->class_level != '') {
            $query->where('class_level', $request->class_level);
        }
        
        // Filter by teacher
        if ($request->has('teacher_id') && $request->teacher_id != '') {
            $query->where('teacher_id', $request->teacher_id);
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
        $sortField = $request->input('sort', 'day_of_week');
        $sortDirection = $request->input('direction', 'asc');
        $query->orderBy($sortField, $sortDirection);
        
        $schedules = $query->paginate(15)->withQueryString();
        $subjects = Subject::where('is_active', true)->orderBy('name')->get();
        $teachers = Staff::orderBy('name')->get();
        
        // Get unique values for filters or provide defaults
        $academicYears = Schedule::distinct()->pluck('academic_year');
        if ($academicYears->isEmpty()) {
            $academicYears = collect(['2023/2024', '2024/2025']);
        }
        
        $semesters = Schedule::distinct()->pluck('semester');
        if ($semesters->isEmpty()) {
            $semesters = collect(['Ganjil', 'Genap']);
        }
        
        $classLevels = Schedule::distinct()->pluck('class_level');
        if ($classLevels->isEmpty()) {
            $classLevels = collect(['1', '2', '3', '4', '5', '6']);
        }
        
        // Define days of week for filter
        $daysOfWeek = [
            'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'
        ];
        
        return view('superadmin.schedules.index', compact(
            'schedules', 
            'subjects', 
            'teachers', 
            'academicYears', 
            'semesters', 
            'classLevels',
            'daysOfWeek'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subjects = Subject::where('is_active', true)->orderBy('name')->get();
        $teachers = Staff::orderBy('name')->get();
        
        // Define days of week
        $daysOfWeek = [
            'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'
        ];
        
        return view('superadmin.schedules.create', compact(
            'subjects', 
            'teachers', 
            'daysOfWeek'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'nullable|exists:staff,id',
            'class_level' => 'required|string|max:10',
            'day_of_week' => 'required|string|max:20',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'room' => 'nullable|string|max:50',
            'academic_year' => 'required|string|max:20',
            'semester' => 'required|string|max:20',
            'status' => 'required|in:active,inactive',
            'notes' => 'nullable|string',
        ]);
        
        try {
            // Create schedule
            $schedule = Schedule::create($validated);
            
            return redirect()->route('superadmin.schedules.index')
                ->with('success', 'Jadwal pembelajaran berhasil ditambahkan');
        } catch (QueryException $e) {
            // Check if it's a unique constraint violation (scheduling conflict)
            if ($e->getCode() == 23000) {
                return redirect()->back()->withInput()
                    ->with('error', 'Jadwal bentrok. Ruangan sudah digunakan pada hari dan waktu tersebut.');
            }
            
            throw $e;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Schedule $schedule)
    {
        $schedule->load('subject', 'teacher');
        return view('superadmin.schedules.show', compact('schedule'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Schedule $schedule)
    {
        $subjects = Subject::where('is_active', true)->orderBy('name')->get();
        $teachers = Staff::orderBy('name')->get();
        
        // Define days of week
        $daysOfWeek = [
            'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'
        ];
        
        return view('superadmin.schedules.edit', compact(
            'schedule', 
            'subjects', 
            'teachers', 
            'daysOfWeek'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Schedule $schedule)
    {
        $validated = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'nullable|exists:staff,id',
            'class_level' => 'required|string|max:10',
            'day_of_week' => 'required|string|max:20',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'room' => 'nullable|string|max:50',
            'academic_year' => 'required|string|max:20',
            'semester' => 'required|string|max:20',
            'status' => 'required|in:active,inactive',
            'notes' => 'nullable|string',
        ]);
        
        try {
            // Update schedule
            $schedule->update($validated);
            
            return redirect()->route('superadmin.schedules.index')
                ->with('success', 'Jadwal pembelajaran berhasil diperbarui');
        } catch (QueryException $e) {
            // Check if it's a unique constraint violation (scheduling conflict)
            if ($e->getCode() == 23000) {
                return redirect()->back()->withInput()
                    ->with('error', 'Jadwal bentrok. Ruangan sudah digunakan pada hari dan waktu tersebut.');
            }
            
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        
        return redirect()->route('superadmin.schedules.index')
            ->with('success', 'Jadwal pembelajaran berhasil dihapus');
    }
    
    /**
     * Toggle schedule status.
     */
    public function toggleStatus(Schedule $schedule)
    {
        $newStatus = $schedule->status === 'active' ? 'inactive' : 'active';
        $schedule->update(['status' => $newStatus]);
        
        return redirect()->route('superadmin.schedules.index')
            ->with('success', 'Status jadwal berhasil diubah');
    }
    
    /**
     * View schedule by day.
     */
    public function viewByDay(Request $request)
    {
        $validated = $request->validate([
            'day_of_week' => 'required|string',
            'class_level' => 'nullable|string',
            'academic_year' => 'required|string',
            'semester' => 'required|string',
        ]);
        
        $query = Schedule::with(['subject', 'teacher'])
            ->where('day_of_week', $validated['day_of_week'])
            ->where('academic_year', $validated['academic_year'])
            ->where('semester', $validated['semester'])
            ->where('status', 'active');
            
        if (isset($validated['class_level'])) {
            $query->where('class_level', $validated['class_level']);
        }
        
        $schedules = $query->orderBy('start_time')->get();
        
        // Group schedules by class level if no specific class is selected
        $groupedSchedules = isset($validated['class_level']) 
            ? ['all' => $schedules] 
            : $schedules->groupBy('class_level');
        
        return view('superadmin.schedules.by-day', compact(
            'groupedSchedules',
            'validated'
        ));
    }
    
    /**
     * View schedule by class.
     */
    public function viewByClass(Request $request)
    {
        $validated = $request->validate([
            'class_level' => 'required|string',
            'academic_year' => 'required|string',
            'semester' => 'required|string',
        ]);
        
        $schedules = Schedule::with(['subject', 'teacher'])
            ->where('class_level', $validated['class_level'])
            ->where('academic_year', $validated['academic_year'])
            ->where('semester', $validated['semester'])
            ->where('status', 'active')
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->get();
            
        // Group schedules by day
        $groupedSchedules = $schedules->groupBy('day_of_week');
        
        // Sort by day of week
        $daysOrder = [
            'Senin' => 1, 
            'Selasa' => 2, 
            'Rabu' => 3, 
            'Kamis' => 4, 
            'Jumat' => 5, 
            'Sabtu' => 6
        ];
        
        $sortedSchedules = $groupedSchedules->sortBy(function ($item, $key) use ($daysOrder) {
            return $daysOrder[$key] ?? 999;
        });
        
        return view('superadmin.schedules.by-class', compact(
            'sortedSchedules',
            'validated'
        ));
    }

    /**
     * Update schedule for a specific day.
     */
    public function updateDay(Request $request, $day)
    {
        // Update day schedule logic
        return redirect()->back()->with('success', 'Jadwal hari berhasil diperbarui');
    }

    /**
     * Update schedule for a specific class.
     */
    public function updateClass(Request $request, $class)
    {
        // Update class schedule logic
        return redirect()->back()->with('success', 'Jadwal kelas berhasil diperbarui');
    }
}
