<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BloodStock extends Model
{
    protected $fillable = [
        'product',
        'stock_a',
        'stock_b',
        'stock_o',
        'stock_ab',
    ];
}
