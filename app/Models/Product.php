<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'desc',
        'price',
        'image',
        'category',
        'stock',
        'specifications'
    ];

    protected $casts = [
        'specifications' => 'array',
        'price' => 'decimal:2'
    ];
}
