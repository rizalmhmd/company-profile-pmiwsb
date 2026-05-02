<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FooterSetting extends Model
{
    protected $fillable = [
        'about_pmi',
        'address',
        'phone',
        'email',
        'facebook',
        'instagram',
        'twitter',
        'youtube',
        'copyright',
    ];
}
