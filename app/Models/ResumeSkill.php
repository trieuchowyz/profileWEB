<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResumeSkill extends Model
{
    /** @use HasFactory<\Database\Factories\ResumeSkillFactory> */
    use HasFactory;

    protected $fillable = [
        'resume_id', 'name', 'level', 'order_index'
    ];

    public function resume()
    {
        return $this->belongsTo(Resume::class);
    }
}
