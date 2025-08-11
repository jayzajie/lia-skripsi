<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AcademicYearController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $academicYears = AcademicYear::orderBy('created_at', 'desc')->get();
        return view('superadmin.academic-years.index', compact('academicYears'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('superadmin.academic-years.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'year' => 'required|string|max:9|unique:academic_years',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        // If this is set as active, deactivate all others
        if (isset($validated['is_active']) && $validated['is_active']) {
            AcademicYear::where('is_active', true)->update(['is_active' => false]);
        }

        AcademicYear::create($validated);

        // Clear cache to refresh year display
        Cache::forget('active_academic_year');

        return redirect()->route('superadmin.academic-years.index')
            ->with('success', 'Tahun ajaran berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AcademicYear $academicYear)
    {
        return view('superadmin.academic-years.edit', compact('academicYear'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AcademicYear $academicYear)
    {
        $validated = $request->validate([
            'year' => 'required|string|max:9|unique:academic_years,year,' . $academicYear->id,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        // If this is set as active, deactivate all others
        if (isset($validated['is_active']) && $validated['is_active'] && !$academicYear->is_active) {
            AcademicYear::where('is_active', true)->update(['is_active' => false]);
        }

        $academicYear->update($validated);

        // Clear cache to refresh year display
        Cache::forget('active_academic_year');

        return redirect()->route('superadmin.academic-years.index')
            ->with('success', 'Tahun ajaran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AcademicYear $academicYear)
    {
        // Don't allow deleting active year
        if ($academicYear->is_active) {
            return redirect()->route('superadmin.academic-years.index')
                ->with('error', 'Tidak dapat menghapus tahun ajaran yang sedang aktif.');
        }

        $academicYear->delete();

        // Clear cache
        Cache::forget('active_academic_year');

        return redirect()->route('superadmin.academic-years.index')
            ->with('success', 'Tahun ajaran berhasil dihapus.');
    }

    /**
     * Set the specified academic year as active.
     */
    public function setActive(AcademicYear $academicYear)
    {
        // Deactivate all academic years
        AcademicYear::where('is_active', true)->update(['is_active' => false]);

        // Set the selected one as active
        $academicYear->update(['is_active' => true]);

        // Clear cache
        Cache::forget('active_academic_year');

        return redirect()->route('superadmin.academic-years.index')
            ->with('success', 'Tahun ajaran ' . $academicYear->year . ' berhasil diaktifkan.');
    }
}