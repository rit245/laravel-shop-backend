<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'description', 'price', 'category_id'];

    protected $casts = [
        'name' => 'string',
        'description' => 'string',
        'price' => 'float',
        'category_id' => 'integer',
    ];
}
