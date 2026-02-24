<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Impian;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function store(Request $request, $impian_id)
    {
        $request->validate([
            'nominal' => 'required|numeric|min:1',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string|max:255'
        ]);

        // Pastikan impian ini benar-benar milik user yang sedang login
        $impian = Impian::where('id', $impian_id)->where('user_id', Auth::id())->firstOrFail();

        // Simpan transaksi
        Transaksi::create([
            'impian_id' => $impian->id,
            'nominal' => $request->nominal,
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan
        ]);

        // Cek apakah impian sudah lunas? Jika ya, ubah statusnya!
        if ($impian->terkumpul >= $impian->target_dana) {
            $impian->update(['status' => 'tercapai']);
        }

        return redirect()->back()->with('success', 'Cicilan impian berhasil ditambahkan! Semangat!');
    }
}