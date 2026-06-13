<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    /** @use HasFactory<\Database\Factories\TemplateFactory> */
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'thumbnail', 'view_path', 'default_styles', 'is_active'
    ];

    protected $casts = [
        'default_styles' => 'array', // Tự động convert JSON từ DB sang Array trong PHP
        'is_active' => 'boolean',
    ];

    // Một template có thể được dùng bởi nhiều CV
    public function resume()
    {
        return $this->hasMany(Resume::class);
    }
}
