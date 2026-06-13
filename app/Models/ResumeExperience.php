<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResumeExperience extends Model
{
    /** @use HasFactory<\Database\Factories\ResumeExperienceFactory> */
    use HasFactory;

    protected $fillable = [
        'resume_id', 'company', 'position', 'start_date', 
        'end_date', 'is_current', 'description', 'order_index'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_current' => 'boolean',
    ];

    public function resume()
    {
        return $this->belongsTo(Resume::class);
    }
}
