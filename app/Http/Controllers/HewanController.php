<?php

namespace App\Http\Controllers;

use App\Models\Hewan;
use App\Models\User;
use Illuminate\Http\Request;

class HewanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Manajemen Hewan";

        // If user has 'user' role, only show their own hewans
        if (auth()->user()->hasRole('user')) {
            $hewans = Hewan::with('pemilik')->where('user_id', auth()->id())->get();
        } else {
            // Admin and doctor can see all hewans
            $hewans = Hewan::with('pemilik')->get();
        }

        return view('hewanManage/index', compact('title', 'hewans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Tambah Hewan Baru";

        // Get users based on role
        if (auth()->user()->hasRole('user')) {
            $users = collect([auth()->user()]); // Only current user
        } else {
            $users = User::role('user')->get(); // All users with 'user' role for admin/doctor
        }

        return view('hewanManage/create', compact('title', 'users'));
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
        return view('hewanManage/show', compact('title', 'hewan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hewan $hewan)
    {
        $title = "Edit Hewan";
        $hewan->load('pemilik');

        // Get users based on role
        if (auth()->user()->hasRole('user')) {
            $users = collect([auth()->user()]); // Only current user
        } else {
            $users = User::role('user')->get(); // All users with 'user' role for admin/doctor
        }

        return view('hewanManage/edit', compact('title', 'hewan', 'users'));
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
