<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Template;
use App\Models\Resume;
use App\Models\ResumeEducation;
use App\Models\ResumeExperience;
use App\Models\ResumeProject;
use App\Models\ResumeSkill;
use Illuminate\Support\Str;

class RealDataSeeder extends Seeder
{
    public function run()
    {
        // 1. Tài khoản đăng nhập
        $user = User::firstOrCreate(
            ['email' => 'trieuuser1872006@gmail.com'],
            ['name' => 'Nguyễn Văn Triều', 'password' => bcrypt('12345678'), 'role' => 'admin']
        );

        // 2. Lấy Template giao diện
        $template = Template::firstOrCreate(
            ['view_path' => 'cv.modern'],
            ['name' => 'Modern IT Pro', 'slug' => 'modern-it-pro', 'is_active' => true]
        );

        // ==========================================
        // CV SỐ 1: FULL-STACK DEVELOPER
        // ==========================================
        $cv1 = Resume::create([
            'user_id'       => $user->id,
            'template_id'   => $template->id,
            'title'         => 'CV Thực tập sinh Full-Stack',
            'slug'          => Str::slug('cv fullstack ' . time()),
            'full_name'     => 'Nguyễn Văn Triều',
            'job_title'     => 'Full-Stack Web Developer',
            'email'         => 'trieuuser1872006@gmail.com',
            'phone'         => '0901 234 567',
            'address'       => 'TP. Hồ Chí Minh',
            'summary'       => 'Sinh viên IT chuyên ngành Web Development. Cập nhật và ứng dụng tốt các framework hiện đại như Angular cho frontend và Laravel cho backend. Định hướng trở thành Full-Stack Developer chuyên nghiệp.',
            'is_public'     => true,
        ]);

        ResumeEducation::create(['resume_id' => $cv1->id, 'school_name' => 'Đại học [Tên trường]', 'degree' => 'Cử nhân Kỹ thuật Phần mềm', 'start_date' => '2022-09-01', 'end_date' => '2026-06-01', 'description' => "Đang hoàn thiện đồ án tốt nghiệp mảng Web Full-stack.", 'order_index' => 0]);
        ResumeProject::create(['resume_id' => $cv1->id, 'project_name' => 'Hệ thống CV Builder', 'role' => 'Full-stack Developer', 'start_date' => '2026-05-01', 'end_date' => '2026-06-01', 'description' => "- Xây dựng hệ thống tạo CV trực tuyến.\n- Chuyển đổi giao diện sang component base.\n- Công nghệ: Laravel, Angular, MySQL.", 'order_index' => 0]);
        ResumeProject::create(['resume_id' => $cv1->id, 'project_name' => 'PressHub News', 'role' => 'Frontend & Backend', 'start_date' => '2026-03-01', 'end_date' => '2026-04-15', 'description' => "- Tái cấu trúc logic Admin và Client riêng biệt.\n- Công nghệ: Node.js, React, Tailwind CSS.", 'order_index' => 1]);

        $skills1 = ['Laravel' => 85, 'Angular' => 80, 'React' => 75, 'MySQL' => 80];
        $idx1 = 0; foreach ($skills1 as $name => $prof) { ResumeSkill::create(['resume_id' => $cv1->id, 'skill_name' => $name, 'proficiency' => $prof, 'order_index' => $idx1++]); }

        // ==========================================
        // CV SỐ 2: BACKEND ENGINEER
        // ==========================================
        $cv2 = Resume::create([
            'user_id'       => $user->id,
            'template_id'   => $template->id,
            'title'         => 'CV Junior Backend',
            'slug'          => Str::slug('cv backend ' . time()),
            'full_name'     => 'Nguyễn Văn Triều',
            'job_title'     => 'Backend Developer',
            'email'         => 'trieuuser1872006@gmail.com',
            'phone'         => '0901 234 567',
            'address'       => 'TP. Hồ Chí Minh',
            'summary'       => 'Đam mê xây dựng API và thiết kế cơ sở dữ liệu. Mạnh về tư duy logic, tối ưu hóa truy vấn và kiến trúc bảo mật. Luôn tìm tòi các giải pháp xử lý dữ liệu lớn.',
            'is_public'     => false,
        ]);

        ResumeEducation::create(['resume_id' => $cv2->id, 'school_name' => 'Đại học [Tên trường]', 'degree' => 'Cử nhân Kỹ thuật Phần mềm', 'start_date' => '2022-09-01', 'end_date' => '2026-06-01', 'description' => "Hoàn thành xuất sắc các môn Cơ sở dữ liệu và Kiến trúc hệ thống.", 'order_index' => 0]);
        ResumeProject::create(['resume_id' => $cv2->id, 'project_name' => 'API Gateway System', 'role' => 'Backend Developer', 'start_date' => '2025-10-01', 'end_date' => '2025-12-01', 'description' => "- Xây dựng hệ thống API bảo mật cao.\n- Tích hợp caching và xử lý queue.\n- Công nghệ: NestJS, MongoDB, Redis.", 'order_index' => 0]);

        $skills2 = ['Node.js (Express/NestJS)' => 85, 'PHP/Laravel' => 85, 'MongoDB' => 80, 'API Design' => 90];
        $idx2 = 0; foreach ($skills2 as $name => $prof) { ResumeSkill::create(['resume_id' => $cv2->id, 'skill_name' => $name, 'proficiency' => $prof, 'order_index' => $idx2++]); }
    }
}
