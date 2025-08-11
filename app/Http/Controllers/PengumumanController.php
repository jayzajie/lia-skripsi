<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PengumumanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $pengumumans = DB::table('pengumumans')
                ->where('status', 'active')
                ->where('tanggal_terbit', '<=', now())
                ->where('tanggal_berakhir', '>=', now())
                ->orderBy('no', 'asc')
                ->get();
                
            return view('dashboard.pengumuman', compact('pengumumans'));
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error in PengumumanController@index: ' . $e->getMessage());
            
            // Return the view with empty data
            $pengumumans = collect([]);
            return view('dashboard.pengumuman', compact('pengumumans'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.pengumuman.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'no' => 'required|string|max:10',
            'nama' => 'required|string|max:255',
            'keterangan' => 'required|string',
            'tanggal_terbit' => 'required|date',
            'tanggal_berakhir' => 'required|date|after:tanggal_terbit',
        ]);

        Pengumuman::create([
            'no' => $request->no,
            'nama' => $request->nama,
            'keterangan' => $request->keterangan,
            'tanggal_terbit' => $request->tanggal_terbit,
            'tanggal_berakhir' => $request->tanggal_berakhir,
            'status' => 'active',
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pengumuman $pengumuman)
    {
        return view('dashboard.pengumuman.show', compact('pengumuman'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengumuman $pengumuman)
    {
        return view('dashboard.pengumuman.edit', compact('pengumuman'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengumuman $pengumuman)
    {
        $request->validate([
            'no' => 'required|string|max:10',
            'nama' => 'required|string|max:255',
            // 'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan', - Dihapus
            'keterangan' => 'required|string',
            'tanggal_terbit' => 'required|date',
            'tanggal_berakhir' => 'required|date|after:tanggal_terbit',
            'status' => 'required|in:active,inactive',
        ]);

        $pengumuman->update([
            'no' => $request->no,
            'nama' => $request->nama,
            // 'jenis_kelamin' => $request->jenis_kelamin, - Dihapus
            'keterangan' => $request->keterangan,
            'tanggal_terbit' => $request->tanggal_terbit,
            'tanggal_berakhir' => $request->tanggal_berakhir,
            'status' => $request->status,
        ]);

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengumuman $pengumuman)
    {
        $pengumuman->delete();

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil dihapus.');
    }

    /**
     * Display active announcements.
     */
    public function active()
    {
        $today = now()->format('Y-m-d');
        
        try {
            $pengumumans = DB::table('pengumumans')
                ->where('status', 'active')
                ->where('tanggal_terbit', '<=', $today)
                ->where('tanggal_berakhir', '>=', $today)
                ->get();
                
            return view('pengumuman.active', compact('pengumumans'));
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error in PengumumanController@active: ' . $e->getMessage());
            
            // Return the view with empty data
            $pengumumans = collect([]);
            return view('pengumuman.active', compact('pengumumans'));
        }
    }
}