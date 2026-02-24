<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Impian extends Model
{
    protected $guarded = [];

    // Tambahkan relasi ke User ini
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    // Relasi ke Transaksi (Satu Impian punya Banyak Transaksi/Cicilan)
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }

    // Fitur menghitung total cicilan terkumpul
    public function getTerkumpulAttribute()
    {
        return $this->transaksis->sum('nominal');
    }

    // Fitur menghitung persentase progress bar (Maksimal 100%)
    public function getProgressAttribute()
    {
        if ($this->target_dana <= 0) return 0;
        
        $persen = ($this->terkumpul / $this->target_dana) * 100;
        return min(100, round($persen)); // Dibatasi mentok di 100%
    }
}