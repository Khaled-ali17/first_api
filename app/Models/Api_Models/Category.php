<?php

namespace App\Models\Api_Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';

    protected $fillable = [
        'id', 'name_ar','name_en','status_active', 'updated_at','created_at',
    ];
}
