<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Experience extends Model
{
    use HasFactory;

    protected $fillable = [
        "nutritionist_id",
        "type",
        "title",
        "institution",
        "description",
        "start_date",
        "end_date"
    ];

    public function nutritionist(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
