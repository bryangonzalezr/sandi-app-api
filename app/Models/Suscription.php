<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suscription extends Model
{
    use HasFactory;

    protected $table = 'suscriptions';

    protected $connection = 'pgsql';

    protected $fillable = [
        'user_id',
        'suscription_type_id',
        'start_date',
        'end_date',
    ];
}
