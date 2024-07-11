<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;

class Tag extends Model
{
    use HasRoles,HasPanelShield,HasRoles;
    protected $fillable = [
        'name',
        'slug',
    ];
}
