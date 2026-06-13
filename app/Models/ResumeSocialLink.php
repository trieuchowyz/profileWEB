<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResumeSocialLink extends Model
{
    /** @use HasFactory<\Database\Factories\ResumeSocialLinkFactory> */
    use HasFactory;

    protected $fillable = [
        'resume_id', 
        'platform', // VD: LinkedIn, GitHub, Facebook, Portfolio
        'url'       // Đường dẫn link
    ];

    /**
     * Liên kết ngược lại với Model Resume
     */
    public function resume()
    {
        return $this->belongsTo(Resume::class);
    }
}
