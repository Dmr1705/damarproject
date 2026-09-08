<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        // Menggunakan pemanggilan namespace langsung (\App\Models\...) 
        // untuk mem-bypass bug linter VS Code pada class berhuruf kecil.

        // Statistik Data Anggota
        $totalAnggota = \App\Models\anggota::count();
        $anggotaAktif = \App\Models\anggota::where('status', 'Aktif')->count();

        // Statistik Berita
        $totalBerita = \App\Models\berita::count();
        $draftBerita = \App\Models\berita::where('status', 'draft')->count();

        // Statistik Pengguna / Akun (Aturan #45)
        $jumlahAdmin = User::where('role', User::ROLE_ADMIN)->count();
        $jumlahAkunAnggota = User::where('role', User::ROLE_ANGGOTA)->count();

        return view('admin.dashboard', compact(
            'totalAnggota', 
            'anggotaAktif', 
            'totalBerita', 
            'draftBerita',
            'jumlahAdmin',
            'jumlahAkunAnggota'
        ));
    }
}