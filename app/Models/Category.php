<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;

class Category extends Model
{
    use HasFactory,HasRoles,HasPanelShield;
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
    ];
}
