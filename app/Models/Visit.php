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
        'height',
        'weight',
        'bicipital_skinfold',
        'tricipital_skinfold',
        'subescapular_skinfold',
        'supraspinal_skinfold',
        'suprailiac_skinfold',
        'pb_relaj',
        'pb_contra',
        'forearm',
        'thigh',
        'calf',
        'waist',
        'thorax',

    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
