<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Salesplan extends Model
{
    use HasFactory;
    protected $fillable = [
        'part_number_assy',
        'part_number_customer',
        'part_name_customer',
        'product',
        'qty_fy24'
    ];
    public function qty(): BelongsTo
    {
        return $this->belongsTo(Bom::class, 'part_number_assy', 'part_number_assy');
    }
}
