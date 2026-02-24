<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $guarded = []; // Izinkan insert data

    public function impian()
    {
        return $this->belongsTo(Impian::class);
    }
}