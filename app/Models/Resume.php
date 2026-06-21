<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ResumeEducation;
use App\Models\ResumeExperience;
use App\Models\ResumeSkill;
use App\Models\ResumeProject;
use App\Models\User;
use App\Models\Template;
use App\Models\ResumeLanguage;
use App\Models\ResumeSocialLink;

class Resume extends Model
{
    /** @use HasFactory<\Database\Factories\ResumeFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'template_id',
        'title',
        'slug',
        'full_name',
        'job_title',
        'email',
        'phone',
        'address',
        'avatar',
        'summary',
        'custom_styles',
        'is_public',
        'pdf_path',
        'section_order'
    ];

    protected $casts = [
        'custom_styles' => 'array', // Convert JSON lưu style cá nhân hóa
        'section_order' => 'array',
        'is_public' => 'boolean',
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function templates()
    {
        return $this->belongsTo('App\\Models\\Template');
    }

    // --- CÁC MỐI QUAN HỆ VỚI CHI TIẾT CV ---

    public function educations()
    {
        return $this->hasMany(ResumeEducation::class)->orderBy('order_index');
    }

    public function experiences()
    {
        return $this->hasMany(ResumeExperience::class)->orderBy('order_index');
    }

    public function skills()
    {
        return $this->hasMany(ResumeSkill::class)->orderBy('order_index');
    }

    public function projects()
    {
        return $this->hasMany(ResumeProject::class)->orderBy('order_index');
    }
    public function languages()
    {
        return $this->hasMany(ResumeLanguage::class);
    }

    public function socialLinks()
    {
        return $this->hasMany(ResumeSocialLink::class);
    }
}
