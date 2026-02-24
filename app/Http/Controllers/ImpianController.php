<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Impian;
use App\Models\Kategori;
use Illuminate\Support\Facades\Auth;

class ImpianController extends Controller
{
    public function index()
    {
        // Ambil kategori untuk pilihan di form
        $kategoris = Kategori::all();
        // Ambil impian milik user yang sedang login
        $impians = Impian::where('user_id', Auth::id())->latest()->get();
        
        return view('dashboard', compact('kategoris', 'impians'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_impian' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'target_dana' => 'required|numeric|min:1',
            'jatuh_tempo' => 'required|date|after:today',
        ]);

        Impian::create([
            'user_id' => Auth::id(),
            'kategori_id' => $request->kategori_id,
            'nama_impian' => $request->nama_impian,
            'target_dana' => $request->target_dana,
            'jatuh_tempo' => $request->jatuh_tempo,
            'status' => 'berjalan',
        ]);

        return redirect()->back()->with('success', 'Impian baru berhasil ditambahkan sebagai hutang!');
    }
}