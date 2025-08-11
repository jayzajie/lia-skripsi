<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Activity::query();

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('created_by', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by type
        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }

        // Filter by published state
        if ($request->has('published')) {
            $query->where('is_published', $request->published);
        }

        // Sort
        $sortField = $request->input('sort', 'date');
        $sortDirection = $request->input('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        $activities = $query->paginate(10)->withQueryString();

        return view('superadmin.activities.index', compact('activities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('superadmin.activities.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'status' => 'required|string|in:Mendatang,Berlangsung,Selesai',
            'description' => 'nullable|string',
            'is_published' => 'boolean',
            'created_by' => 'required|string|max:255',
        ]);

        if (!isset($validated['is_published'])) {
            $validated['is_published'] = false;
        }

        Activity::create($validated);

        return redirect()->route('superadmin.activities.index')
            ->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    // Juga perbarui method update
    public function update(Request $request, Activity $activity)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'status' => 'required|string|in:Mendatang,Berlangsung,Selesai',
            'description' => 'nullable|string',
            'is_published' => 'boolean',
            'created_by' => 'required|string|max:255',
        ]);

        // Set is_published default if not provided
        if (!isset($validated['is_published'])) {
            $validated['is_published'] = false;
        }

        $activity->update($validated);

        return redirect()->route('superadmin.activities.index')
            ->with('success', 'Kegiatan berhasil diperbarui.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Activity $activity)
    {
        return view('superadmin.activities.show', compact('activity'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Activity $activity)
    {
        return view('superadmin.activities.edit', compact('activity'));
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, Activity $activity)
    // {
    //     $validated = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'date' => 'required|date',
    //         'location' => 'required|string|max:255',
    //         'status' => 'required|string|in:Mendatang,Berlangsung,Selesai',
    //         'description' => 'nullable|string',
    //         'is_published' => 'boolean',
    //     ]);

    //     // Set is_published default if not provided
    //     if (!isset($validated['is_published'])) {
    //         $validated['is_published'] = false;
    //     }

    //     $activity->update($validated);

    //     return redirect()->route('superadmin.activities.index')
    //         ->with('success', 'Kegiatan berhasil diperbarui.');
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Activity $activity)
    {
        $activity->delete();

        return redirect()->route('superadmin.activities.index')
            ->with('success', 'Kegiatan berhasil dihapus.');
    }

    /**
     * Toggle the published status of the activity.
     */
    public function togglePublished(Activity $activity)
    {
        $activity->is_published = !$activity->is_published;
        $activity->save();

        $status = $activity->is_published ? 'dipublikasikan' : 'disembunyikan';
        return redirect()->route('superadmin.activities.index')
            ->with('success', "Kegiatan berhasil {$status}.");
    }
}
