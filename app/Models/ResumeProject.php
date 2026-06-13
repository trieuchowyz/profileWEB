<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResumeProject extends Model
{
    /** @use HasFactory<\Database\Factories\ResumeProjectFactory> */
    use HasFactory;

    protected $fillable = [
        'resume_id', 'name', 'role', 'link', 'start_date', 
        'end_date', 'description', 'order_index'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function resume()
    {
        return $this->belongsTo(Resume::class);
    }
}
