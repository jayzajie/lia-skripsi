<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Subject::with('teacher');
        
        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Filter by class level
        if ($request->has('class_level') && $request->class_level != '') {
            $query->where('class_level', $request->class_level);
        }
        
        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        // Filter by teacher
        if ($request->has('teacher_id') && $request->teacher_id != '') {
            $query->where('teacher_id', $request->teacher_id);
        }
        
        // Sort
        $sortField = $request->input('sort', 'name');
        $sortDirection = $request->input('direction', 'asc');
        $query->orderBy($sortField, $sortDirection);
        
        $subjects = $query->paginate(10)->withQueryString();
        $teachers = Staff::orderBy('name')->get();
        
        return view('superadmin.subjects.index', compact('subjects', 'teachers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teachers = Staff::orderBy('name')->get();
        return view('superadmin.subjects.create', compact('teachers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50|unique:subjects,code',
            'description' => 'nullable|string',
            'credit_hours' => 'nullable|integer|min:0',
            'class_level' => 'nullable|string|max:10',
            'status' => 'required|in:active,inactive',
            'teacher_id' => 'nullable|exists:staff,id',
        ]);
        
        // Create subject
        $subject = Subject::create($validated);
        
        return redirect()->route('superadmin.subjects.index')
            ->with('success', 'Mata pelajaran berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        $subject->load('teacher', 'schedules');
        return view('superadmin.subjects.show', compact('subject'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject)
    {
        $teachers = Staff::orderBy('name')->get();
        return view('superadmin.subjects.edit', compact('subject', 'teachers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => ['nullable', 'string', 'max:50', Rule::unique('subjects')->ignore($subject->id)],
            'description' => 'nullable|string',
            'credit_hours' => 'nullable|integer|min:0',
            'class_level' => 'nullable|string|max:10',
            'status' => 'required|in:active,inactive',
            'teacher_id' => 'nullable|exists:staff,id',
        ]);
        
        // Update subject
        $subject->update($validated);
        
        return redirect()->route('superadmin.subjects.index')
            ->with('success', 'Mata pelajaran berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();
        
        return redirect()->route('superadmin.subjects.index')
            ->with('success', 'Mata pelajaran berhasil dihapus');
    }
    
    /**
     * Update teacher assignment.
     */
    public function assignTeacher(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'teacher_id' => 'nullable|exists:staff,id',
        ]);
        
        $subject->update(['teacher_id' => $validated['teacher_id']]);
        
        return redirect()->route('superadmin.subjects.show', $subject)
            ->with('success', 'Pengajar berhasil diperbarui');
    }
    
    /**
     * Toggle subject status.
     */
    public function toggleStatus(Subject $subject)
    {
        $newStatus = $subject->status === 'active' ? 'inactive' : 'active';
        $subject->update(['status' => $newStatus]);
        
        return redirect()->route('superadmin.subjects.index')
            ->with('success', 'Status mata pelajaran berhasil diubah');
    }
}
