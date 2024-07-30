<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class APR extends Model
{
    use HasFactory;
    protected $fillable = [
        'supplier_id',
        'periode',
        'file'
    ];
    public function suppliers(): HasMany
    {
        return $this->hasMany(Supplier::class, 'id', 'supplier_id');
    }
}
