<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class bom extends Model
{
    use HasFactory;
    protected $fillable = [
        'level',
        'part_number_comp',
        'part_name_comp',
        'part_number_assy',
        'part_name_assy',
        'qty_usage_for_assy',
        'uom'
    ];
    public function qty(): HasMany
    {
        return $this->hasMany(Salesplan::class, 'part_number_assy', 'part_number_assy');
    }
    public function supplier(): HasMany
    {
        return $this->hasMany(Suppliersr::class, 'part_number_comp', 'part_number_comp');
    }
    public function price(): HasMany
    {
        return $this->hasMany(Price::class, 'part_number_comp', 'part_number_comp');
    }
}
