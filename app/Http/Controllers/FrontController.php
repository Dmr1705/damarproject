<?php

namespace App\Http\Controllers;

use App\Models\berita;

class FrontController extends Controller
{
    public function index()
    {
        $beritas = berita::where('status', 'published')->latest()->take(6)->get();
        return view('welcome', compact('beritas'));
    }

    public function show(int $id)
    {
        $berita = berita::where('status', 'published')->findOrFail($id);
        return view('berita-detail', compact('berita'));
    }
}