<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactCard extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'pgsql';

    protected $fillable = [
        'nutritionist_id',
        'commune_id',
        'address',
        'slogan',
        'specialties',
        'description',
    ];

    public function nutritionist()
    {
        return $this->belongsTo(User::class, 'nutritionist_id');
    }

    public function commune()
    {
        return $this->belongsTo(Commune::class, 'commune_id');
    }

    public function experience()
    {
        return $this->hasMany(Experience::class);
    }
}
