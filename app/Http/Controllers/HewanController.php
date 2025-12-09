<?php

namespace App\Http\Controllers;

use App\Models\Hewan;
use Illuminate\Http\Request;

class HewanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Manajemen Hewan";
        $hewans = Hewan::with('pemilik')->get();
        return view('admin/hewanManage/index', compact('title', 'hewans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Tambah Hewan Baru";
        return view('admin/hewanManage/create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'nama' => ['required', 'string', 'max:255'],
            'jenis' => ['required', 'string', 'max:255'],
            'ras' => ['required', 'string', 'max:255'],
            'umur' => ['required', 'integer', 'min:0'],
        ]);

        Hewan::create($validated);

        return redirect()->route('hewan.index')
            ->with('success', 'Hewan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Hewan $hewan)
    {
        $title = "Detail Hewan";
        $hewan->load(['pemilik', 'rekamMedis.dokter.user', 'rekamMedis.layanan']);
        return view('admin/hewanManage/show', compact('title', 'hewan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hewan $hewan)
    {
        $title = "Edit Hewan";
        $hewan->load('pemilik');
        return view('admin/hewanManage/edit', compact('title', 'hewan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hewan $hewan)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'nama' => ['required', 'string', 'max:255'],
            'jenis' => ['required', 'string', 'max:255'],
            'ras' => ['required', 'string', 'max:255'],
            'umur' => ['required', 'integer', 'min:0'],
        ]);

        $hewan->update($validated);

        return redirect()->route('hewan.index')
            ->with('success', 'Hewan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hewan $hewan)
    {
        $hewan->delete();

        return redirect()->route('hewan.index')
            ->with('success', 'Hewan berhasil dihapus.');
    }
}
