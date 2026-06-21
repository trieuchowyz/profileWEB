<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Template;
use App\Models\Resume;

class ResumeSeeder extends Seeder
{
    public function run()
    {
        // 1. Lấy user đầu tiên (hoặc tạo mới)
        $user = User::firstOrCreate(
            ['email' => 'test@cvbuilder.com'],
            ['name' => 'Test User', 'password' => bcrypt('123456')]
        );

        // 2. Lấy cái Template vừa tạo ở Bước 2
        $template = Template::where('view_path', 'cv.template1')->first();

        // 3. Tạo data CV chính
        $resume = Resume::updateOrCreate(
            ['slug' => 'cv-hoang-minh-it'],
            [
                'user_id' => $user->id,
                'template_id' => $template->id,
                'title' => 'CV Ứng tuyển Web Dev',
                'full_name' => 'Hoàng Minh',
                'job_title' => 'Fullstack Web Developer',
                'email' => 'hoangminh@email.com',
                'phone' => '0988 123 456',
                'address' => 'Quận 1, TP. HCM',
                'summary' => 'Lập trình viên đam mê công nghệ, chuyên xây dựng các hệ thống web hiệu năng cao.',
                'is_public' => true,
            ]
        );

        // 4. Xóa data cũ (nếu chạy seed nhiều lần) và tạo data chi tiết mới
        $resume->experiences()->delete();
        $resume->skills()->delete();

        $resume->experiences()->create([
            'company' => 'Tech Company A',
            'position' => 'Backend Developer',
            'start_date' => '2023-01-01',
            'end_date' => '2025-12-01',
            'description' => 'Phát triển RESTful API cho hệ thống ERP nội bộ.',
            'order_index' => 1
        ]);

        $resume->skills()->create(['name' => 'Laravel', 'level' => 90, 'order_index' => 1]);
        $resume->skills()->create(['name' => 'Angular', 'level' => 80, 'order_index' => 2]);
    }
}