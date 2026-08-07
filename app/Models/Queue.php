<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    protected $fillable = ['counter_id', 'queue_number', 'patient_name', 'status'];

    public function counter()
    {
        return $this->belongsTo(Counter::class);
    }
}
