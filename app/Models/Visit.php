<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $connection = 'pgsql';

    protected $fillable = [
        'date',
        'patient_id',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
