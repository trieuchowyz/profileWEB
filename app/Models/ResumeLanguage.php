<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResumeLanguage extends Model
{
    /** @use HasFactory<\Database\Factories\ResumeLanguageFactory> */
    use HasFactory;

    // Khai báo các cột có thể điền dữ liệu (Mass Assignment)
    protected $fillable = [
        'resume_id', 
        'language',    // VD: Tiếng Anh, Tiếng Nhật
        'proficiency'  // VD: IELTS 7.5, N2, hoặc Thành thạo
    ];

    /**
     * Liên kết ngược lại với Model Resume
     */
    public function resume()
    {
        return $this->belongsTo(Resume::class);
    }
}
