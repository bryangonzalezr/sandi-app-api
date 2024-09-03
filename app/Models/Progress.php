<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    use HasFactory;

    protected $connection = 'pgsql';

    protected $fillable = [
        'patient_id',
        'imc',
        'fat_percentage',
        'muscular_percentage',
        'nutritional_state',
    ];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }
}
