<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suppliersr extends Model
{
    use HasFactory;
    protected $fillable = [
        'part_number_comp',
        'supplier'
    ];
}
