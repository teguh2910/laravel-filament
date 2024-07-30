<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_supplier',
        'periode_supplier',
        'jenis_supplier',
        'kategori_supplier'
    ];
    public function apr()
    {
        return $this->belongsTo(APR::class);
    }
}
