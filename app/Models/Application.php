<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_status_id',
        'course_id',
        'review',
    ];

    public function status()
    {
        return $this->belongsTo(ApplicationStatus::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
