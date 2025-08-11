<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Staff::query();
        
        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%");
            });
        }
        
        // Filter by position
        if ($request->has('position') && $request->position != '') {
            $query->where('position', $request->position);
        }
        
        // Sort
        $sortField = $request->input('sort', 'name');
        $sortDirection = $request->input('direction', 'asc');
        $query->orderBy($sortField, $sortDirection);
        
        $staff = $query->paginate(10)->withQueryString();
        
        return view('superadmin.staff.index', compact('staff'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('superadmin.staff.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50|unique:staff,nip',
            'gender' => 'required|in:male,female',
            'position' => 'required|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255|unique:staff,email',
            'birth_place' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'religion' => 'nullable|string|max:50',
            'education' => 'nullable|string|max:255',
            'join_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'photo' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
        ]);
        
        // Handle file upload
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = 'staff_' . Str::slug($validated['name']) . '_' . time() . '.' . $photo->getClientOriginalExtension();
            $path = $photo->storeAs('public/staff', $filename);
            $validated['photo'] = str_replace('public/', '', $path);
        }
        
        // Create staff
        $staff = Staff::create($validated);
        
        return redirect()->route('superadmin.staff.index')
            ->with('success', 'Data pegawai berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Staff $staff)
    {
        return view('superadmin.staff.show', compact('staff'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Staff $staff)
    {
        return view('superadmin.staff.edit', compact('staff'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Staff $staff)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nip' => ['nullable', 'string', 'max:50', Rule::unique('staff')->ignore($staff->id)],
            'gender' => 'required|in:male,female',
            'position' => 'required|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'email' => ['nullable', 'email', 'max:255', Rule::unique('staff')->ignore($staff->id)],
            'birth_place' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'religion' => 'nullable|string|max:50',
            'education' => 'nullable|string|max:255',
            'join_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'photo' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
        ]);
        
        // Handle file upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($staff->photo && Storage::exists('public/' . $staff->photo)) {
                Storage::delete('public/' . $staff->photo);
            }
            
            $photo = $request->file('photo');
            $filename = 'staff_' . Str::slug($validated['name']) . '_' . time() . '.' . $photo->getClientOriginalExtension();
            $path = $photo->storeAs('public/staff', $filename);
            $validated['photo'] = str_replace('public/', '', $path);
        }
        
        // Update staff
        $staff->update($validated);
        
        return redirect()->route('superadmin.staff.index')
            ->with('success', 'Data pegawai berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Staff $staff)
    {
        // Delete photo if exists
        if ($staff->photo && Storage::exists('public/' . $staff->photo)) {
            Storage::delete('public/' . $staff->photo);
        }
        
        $staff->delete();
        
        return redirect()->route('superadmin.staff.index')
            ->with('success', 'Data pegawai berhasil dihapus');
    }
    
    /**
     * Link staff to user account.
     */
    public function linkUser(Request $request, Staff $staff)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);
        
        $staff->update(['user_id' => $validated['user_id']]);
        
        return redirect()->route('superadmin.staff.show', $staff)
            ->with('success', 'Akun pengguna berhasil dihubungkan dengan pegawai');
    }
    
    /**
     * Unlink staff from user account.
     */
    public function unlinkUser(Staff $staff)
    {
        $staff->update(['user_id' => null]);
        
        return redirect()->route('superadmin.staff.show', $staff)
            ->with('success', 'Akun pengguna berhasil diputuskan dari pegawai');
    }
}
