<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResumeEducation extends Model
{
    /** @use HasFactory<\Database\Factories\ResumeEducationFactory> */
    use HasFactory;

    protected $fillable = [
        'resume_id', 'institution', 'degree', 'start_date', 
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
