<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Template;
use App\Models\Resume;
use App\Models\ResumeEducation;
use App\Models\ResumeExperience;
use App\Models\ResumeSkill;
use App\Models\ResumeProject;
use App\Models\ResumeLanguage;
use App\Models\ResumeSocialLink;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // =====================================================================
        // 1. TEMPLATES
        // =====================================================================
        $templates = [
            [
                'name'           => 'Classic Professional',
                'slug'           => 'classic-professional',
                'thumbnail'      => 'templates/thumbnails/classic.png',
                'view_path'      => 'cv.template1',
                'default_styles' => json_encode([
                    'primary_color'    => '#2563eb',
                    'font_family'      => 'Inter, sans-serif',
                    'font_size'        => '14px',
                    'layout'           => 'single-column',
                ]),
                'is_active'      => true,
            ],
            [
                'name'           => 'Modern Sidebar',
                'slug'           => 'modern-sidebar',
                'thumbnail'      => 'templates/thumbnails/modern.png',
                'view_path'      => 'cv.template2',
                'default_styles' => json_encode([
                    'primary_color'    => '#7c3aed',
                    'font_family'      => 'Poppins, sans-serif',
                    'font_size'        => '13px',
                    'layout'           => 'two-column',
                    'sidebar_color'    => '#1e1b4b',
                ]),
                'is_active'      => true,
            ],
            [
                'name'           => 'Minimal Clean',
                'slug'           => 'minimal-clean',
                'thumbnail'      => 'templates/thumbnails/minimal.png',
                'view_path'      => 'cv.template3',
                'default_styles' => json_encode([
                    'primary_color'    => '#0f766e',
                    'font_family'      => 'Georgia, serif',
                    'font_size'        => '13px',
                    'layout'           => 'single-column',
                ]),
                'is_active'      => true,
            ],
            [
                'name'           => 'IT Developer',
                'slug'           => 'it-developer',
                'thumbnail'      => 'templates/thumbnails/it-dev.png',
                'view_path'      => 'cv.template4',
                'default_styles' => json_encode([
                    'primary_color'    => '#0ea5e9',
                    'font_family'      => 'JetBrains Mono, monospace',
                    'font_size'        => '13px',
                    'layout'           => 'two-column',
                    'accent_color'     => '#38bdf8',
                ]),
                'is_active'      => true,
            ],
            [
                'name'           => 'Colorful Creative',
                'slug'           => 'colorful-creative',
                'thumbnail'      => 'templates/thumbnails/colorful.png',
                'view_path'      => 'cv.template5',
                'default_styles' => json_encode([
                    'primary_color'    => '#e11d48',
                    'font_family'      => 'Nunito, sans-serif',
                    'font_size'        => '14px',
                    'layout'           => 'two-column',
                ]),
                'is_active'      => true,
            ],
        ];

        foreach ($templates as $tpl) {
            Template::firstOrCreate(['slug' => $tpl['slug']], $tpl);
        }

        $template1 = Template::where('slug', 'classic-professional')->first();
        $template2 = Template::where('slug', 'modern-sidebar')->first();
        $template4 = Template::where('slug', 'it-developer')->first();

        // =====================================================================
        // 2. USERS
        // =====================================================================
        $admin = User::firstOrCreate(
            ['email' => 'admin@cvpro.vn'],
            [
                'name'     => 'Admin CVPro',
                'password' => Hash::make('password'),
                'role'     => 'admin',
            ]
        );

        $user1 = User::firstOrCreate(
            ['email' => 'nguyen.van.an@gmail.com'],
            [
                'name'     => 'Nguyễn Văn An',
                'password' => Hash::make('password'),
                'role'     => 'user',
            ]
        );

        $user2 = User::firstOrCreate(
            ['email' => 'tran.thi.bich@gmail.com'],
            [
                'name'     => 'Trần Thị Bích',
                'password' => Hash::make('password'),
                'role'     => 'user',
            ]
        );

        $user3 = User::firstOrCreate(
            ['email' => 'le.minh.duc@gmail.com'],
            [
                'name'     => 'Lê Minh Đức',
                'password' => Hash::make('password'),
                'role'     => 'user',
            ]
        );

        // =====================================================================
        // 3. RESUMES
        // =====================================================================

        // -------------------------------------------------------------------
        // CV #1 — Nguyễn Văn An — Backend Developer (PHP/Laravel)
        // -------------------------------------------------------------------
        $resume1 = Resume::firstOrCreate(
            ['slug' => 'nguyen-van-an-backend-developer'],
            [
                'user_id'       => $user1->id,
                'template_id'   => $template4->id,
                'title'         => 'CV Backend Developer - PHP/Laravel',
                'full_name'     => 'Nguyễn Văn An',
                'job_title'     => 'Backend Developer',
                'email'         => 'nguyen.van.an@gmail.com',
                'phone'         => '0901 234 567',
                'address'       => 'Quận 7, TP. Hồ Chí Minh',
                'summary'       => 'Backend Developer với 3 năm kinh nghiệm phát triển ứng dụng web bằng PHP/Laravel và Node.js. Có kinh nghiệm thiết kế RESTful API, tối ưu database, và làm việc theo quy trình Agile/Scrum. Mong muốn gia nhập đội ngũ kỹ thuật mạnh để tiếp tục phát triển kỹ năng và đóng góp vào sản phẩm thực tế.',
                'custom_styles' => json_encode(['primary_color' => '#0ea5e9']),
                'is_public'     => true,
                'section_order' => json_encode(['summary', 'experience', 'education', 'skills', 'projects', 'languages', 'social_links']),
            ]
        );

        if ($resume1->wasRecentlyCreated) {
            // Education
            ResumeEducation::insert([
                [
                    'resume_id'   => $resume1->id,
                    'institution' => 'Đại học Bách Khoa TP. Hồ Chí Minh',
                    'degree'      => 'Cử nhân Công nghệ Thông tin',
                    'start_date'  => '2017-09-01',
                    'end_date'    => '2021-07-01',
                    'is_current'  => false,
                    'description' => 'GPA: 3.2/4.0. Chuyên ngành Kỹ thuật Phần mềm. Tham gia CLB Lập trình BKU-IT.',
                    'order_index' => 1,
                    'created_at'  => now(), 'updated_at' => now(),
                ],
            ]);

            // Experience
            ResumeExperience::insert([
                [
                    'resume_id'   => $resume1->id,
                    'company'     => 'FPT Software',
                    'position'    => 'Backend Developer',
                    'start_date'  => '2022-08-01',
                    'end_date'    => null,
                    'is_current'  => true,
                    'description' => "- Phát triển và bảo trì hệ thống quản lý nhân sự cho khách hàng Nhật Bản sử dụng Laravel 10 + MySQL.\n- Thiết kế RESTful API phục vụ ứng dụng mobile React Native (50k+ users).\n- Tối ưu query giảm thời gian phản hồi từ 2s xuống còn 200ms bằng cách sử dụng Redis cache và index.\n- Tham gia code review và mentor 2 intern.",
                    'order_index' => 1,
                    'created_at'  => now(), 'updated_at' => now(),
                ],
                [
                    'resume_id'   => $resume1->id,
                    'company'     => 'TechViet JSC',
                    'position'    => 'Junior PHP Developer',
                    'start_date'  => '2021-08-01',
                    'end_date'    => '2022-07-01',
                    'is_current'  => false,
                    'description' => "- Xây dựng tính năng thanh toán online tích hợp VNPay, MoMo cho hệ thống thương mại điện tử.\n- Phát triển module quản lý kho hàng và báo cáo doanh thu bằng Laravel + Vue.js.\n- Viết unit test với PHPUnit, đạt coverage 75%.",
                    'order_index' => 2,
                    'created_at'  => now(), 'updated_at' => now(),
                ],
            ]);

            // Skills
            ResumeSkill::insert([
                ['resume_id' => $resume1->id, 'name' => 'PHP / Laravel',      'level' => 90,   'order_index' => 1, 'created_at' => now(), 'updated_at' => now()],
                ['resume_id' => $resume1->id, 'name' => 'MySQL / PostgreSQL',  'level' => 90,   'order_index' => 2, 'created_at' => now(), 'updated_at' => now()],
                ['resume_id' => $resume1->id, 'name' => 'RESTful API Design',  'level' => 90,   'order_index' => 3, 'created_at' => now(), 'updated_at' => now()],
                ['resume_id' => $resume1->id, 'name' => 'Redis',               'level' => 60,    'order_index' => 4, 'created_at' => now(), 'updated_at' => now()],
                ['resume_id' => $resume1->id, 'name' => 'Node.js / Express',   'level' => 60,    'order_index' => 5, 'created_at' => now(), 'updated_at' => now()],
                ['resume_id' => $resume1->id, 'name' => 'Docker',              'level' => 30,       'order_index' => 6, 'created_at' => now(), 'updated_at' => now()],
                ['resume_id' => $resume1->id, 'name' => 'Git / GitHub',        'level' => 90,   'order_index' => 7, 'created_at' => now(), 'updated_at' => now()],
                ['resume_id' => $resume1->id, 'name' => 'Linux / Ubuntu',      'level' => 60,    'order_index' => 8, 'created_at' => now(), 'updated_at' => now()],
            ]);

            // Projects
            ResumeProject::insert([
                [
                    'resume_id'   => $resume1->id,
                    'name'        => 'Hệ thống quản lý nhân sự HRM-Pro',
                    'role'        => 'Backend Developer',
                    'link'        => 'https://github.com/nguyenvanan/hrm-pro',
                    'start_date'  => '2023-01-01',
                    'end_date'    => '2023-09-01',
                    'description' => "Hệ thống HRM cho doanh nghiệp vừa và nhỏ. Tech stack: Laravel 10, MySQL, Redis, Vue.js 3.\n- Quản lý nhân viên, chấm công, tính lương tự động.\n- Tích hợp gửi email thông báo qua Queue Jobs.\n- Deploy trên AWS EC2 với CI/CD bằng GitHub Actions.",
                    'order_index' => 1,
                    'created_at'  => now(), 'updated_at' => now(),
                ],
                [
                    'resume_id'   => $resume1->id,
                    'name'        => 'API E-commerce Platform',
                    'role'        => 'Backend Lead',
                    'link'        => 'https://github.com/nguyenvanan/ecom-api',
                    'start_date'  => '2022-10-01',
                    'end_date'    => '2023-03-01',
                    'description' => "RESTful API cho app mua sắm đa nền tảng (iOS/Android). Tech stack: Laravel Sanctum, MySQL, Stripe.\n- 40+ endpoints, xử lý 10.000 requests/ngày.\n- Implement rate limiting, caching với Redis.",
                    'order_index' => 2,
                    'created_at'  => now(), 'updated_at' => now(),
                ],
            ]);

            // Languages
            ResumeLanguage::insert([
                ['resume_id' => $resume1->id, 'language' => 'Tiếng Việt', 'proficiency' => 'Bản ngữ',    'created_at' => now(), 'updated_at' => now()],
                ['resume_id' => $resume1->id, 'language' => 'Tiếng Anh',  'proficiency' => 'TOEIC 750',  'created_at' => now(), 'updated_at' => now()],
                ['resume_id' => $resume1->id, 'language' => 'Tiếng Nhật', 'proficiency' => 'N4',         'created_at' => now(), 'updated_at' => now()],
            ]);

            // Social Links
            ResumeSocialLink::insert([
                ['resume_id' => $resume1->id, 'platform' => 'GitHub',    'url' => 'https://github.com/nguyenvanan',                      'created_at' => now(), 'updated_at' => now()],
                ['resume_id' => $resume1->id, 'platform' => 'LinkedIn',  'url' => 'https://linkedin.com/in/nguyen-van-an',               'created_at' => now(), 'updated_at' => now()],
                ['resume_id' => $resume1->id, 'platform' => 'Portfolio', 'url' => 'https://nguyenvanan.dev',                             'created_at' => now(), 'updated_at' => now()],
            ]);
        }

        // -------------------------------------------------------------------
        // CV #2 — Nguyễn Văn An — CV thứ 2 (Fullstack, đang private)
        // -------------------------------------------------------------------
        $resume2 = Resume::firstOrCreate(
            ['slug' => 'nguyen-van-an-fullstack'],
            [
                'user_id'       => $user1->id,
                'template_id'   => $template2->id,
                'title'         => 'CV Fullstack Developer',
                'full_name'     => 'Nguyễn Văn An',
                'job_title'     => 'Fullstack Developer',
                'email'         => 'nguyen.van.an@gmail.com',
                'phone'         => '0901 234 567',
                'address'       => 'Quận 7, TP. Hồ Chí Minh',
                'summary'       => 'Fullstack Developer với kinh nghiệm xây dựng sản phẩm từ đầu đến cuối. Thành thạo Laravel (backend) và Vue.js/React (frontend). Đam mê tạo ra những sản phẩm có UX tốt và hiệu năng cao.',
                'custom_styles' => json_encode(['primary_color' => '#7c3aed']),
                'is_public'     => false,
                'section_order' => json_encode(['summary', 'skills', 'experience', 'projects', 'education']),
            ]
        );

        if ($resume2->wasRecentlyCreated) {
            ResumeEducation::insert([
                [
                    'resume_id'   => $resume2->id,
                    'institution' => 'Đại học Bách Khoa TP. Hồ Chí Minh',
                    'degree'      => 'Cử nhân Công nghệ Thông tin',
                    'start_date'  => '2017-09-01',
                    'end_date'    => '2021-07-01',
                    'is_current'  => false,
                    'description' => 'GPA: 3.2/4.0. Chuyên ngành Kỹ thuật Phần mềm.',
                    'order_index' => 1,
                    'created_at'  => now(), 'updated_at' => now(),
                ],
            ]);

            ResumeSkill::insert([
                ['resume_id' => $resume2->id, 'name' => 'Laravel',     'level' => 90, 'order_index' => 1, 'created_at' => now(), 'updated_at' => now()],
                ['resume_id' => $resume2->id, 'name' => 'Vue.js 3',    'level' => 90, 'order_index' => 2, 'created_at' => now(), 'updated_at' => now()],
                ['resume_id' => $resume2->id, 'name' => 'React.js',    'level' => 60,  'order_index' => 3, 'created_at' => now(), 'updated_at' => now()],
                ['resume_id' => $resume2->id, 'name' => 'MySQL',       'level' => 90, 'order_index' => 4, 'created_at' => now(), 'updated_at' => now()],
                ['resume_id' => $resume2->id, 'name' => 'TailwindCSS', 'level' => 90, 'order_index' => 5, 'created_at' => now(), 'updated_at' => now()],
            ]);

            ResumeLanguage::insert([
                ['resume_id' => $resume2->id, 'language' => 'Tiếng Việt', 'proficiency' => 'Bản ngữ',   'created_at' => now(), 'updated_at' => now()],
                ['resume_id' => $resume2->id, 'language' => 'Tiếng Anh',  'proficiency' => 'TOEIC 750', 'created_at' => now(), 'updated_at' => now()],
            ]);

            ResumeSocialLink::insert([
                ['resume_id' => $resume2->id, 'platform' => 'GitHub',   'url' => 'https://github.com/nguyenvanan',        'created_at' => now(), 'updated_at' => now()],
                ['resume_id' => $resume2->id, 'platform' => 'LinkedIn', 'url' => 'https://linkedin.com/in/nguyen-van-an', 'created_at' => now(), 'updated_at' => now()],
            ]);
        }

        // -------------------------------------------------------------------
        // CV #3 — Trần Thị Bích — Marketing Manager
        // -------------------------------------------------------------------
        $resume3 = Resume::firstOrCreate(
            ['slug' => 'tran-thi-bich-marketing-manager'],
            [
                'user_id'       => $user2->id,
                'template_id'   => $template1->id,
                'title'         => 'CV Marketing Manager',
                'full_name'     => 'Trần Thị Bích',
                'job_title'     => 'Marketing Manager',
                'email'         => 'tran.thi.bich@gmail.com',
                'phone'         => '0912 345 678',
                'address'       => 'Quận Bình Thạnh, TP. Hồ Chí Minh',
                'summary'       => 'Marketing Manager với 5 năm kinh nghiệm trong lĩnh vực FMCG và thương mại điện tử. Có thành tích dẫn dắt các chiến dịch marketing đa kênh (Digital, Social Media, Performance Marketing) đạt ROI vượt kỳ vọng. Kỹ năng lãnh đạo đội nhóm và làm việc với agency.',
                'custom_styles' => json_encode(['primary_color' => '#2563eb']),
                'is_public'     => true,
                'section_order' => json_encode(['summary', 'experience', 'education', 'skills', 'projects', 'languages', 'social_links']),
            ]
        );

        if ($resume3->wasRecentlyCreated) {
            ResumeEducation::insert([
                [
                    'resume_id'   => $resume3->id,
                    'institution' => 'Đại học Kinh tế TP. Hồ Chí Minh (UEH)',
                    'degree'      => 'Cử nhân Quản trị Kinh doanh - Chuyên ngành Marketing',
                    'start_date'  => '2015-09-01',
                    'end_date'    => '2019-07-01',
                    'is_current'  => false,
                    'description' => 'GPA: 3.6/4.0. Tốt nghiệp Giỏi. Đạt học bổng khuyến học 2 năm liên tiếp.',
                    'order_index' => 1,
                    'created_at'  => now(), 'updated_at' => now(),
                ],
                [
                    'resume_id'   => $resume3->id,
                    'institution' => 'Học viện Digital Marketing Quốc tế (IDMA)',
                    'degree'      => 'Chứng chỉ Google Ads & Analytics',
                    'start_date'  => '2020-01-01',
                    'end_date'    => '2020-06-01',
                    'is_current'  => false,
                    'description' => 'Google Ads Search, Display, Shopping. Google Analytics 4 Certification.',
                    'order_index' => 2,
                    'created_at'  => now(), 'updated_at' => now(),
                ],
            ]);

            ResumeExperience::insert([
                [
                    'resume_id'   => $resume3->id,
                    'company'     => 'Vinamilk',
                    'position'    => 'Marketing Manager',
                    'start_date'  => '2022-04-01',
                    'end_date'    => null,
                    'is_current'  => true,
                    'description' => "- Quản lý ngân sách marketing 5 tỷ/năm cho dòng sản phẩm sữa tươi.\n- Lên kế hoạch và triển khai chiến dịch Tết 2024 đạt 120% KPI doanh số.\n- Quản lý đội nhóm 8 người (Brand, Digital, Trade Marketing).\n- Hợp tác với agency McCann để sản xuất TVC phát sóng toàn quốc.\n- Tăng lượng follower fanpage từ 200K lên 500K trong 12 tháng.",
                    'order_index' => 1,
                    'created_at'  => now(), 'updated_at' => now(),
                ],
                [
                    'resume_id'   => $resume3->id,
                    'company'     => 'Shopee Vietnam',
                    'position'    => 'Senior Marketing Executive',
                    'start_date'  => '2020-06-01',
                    'end_date'    => '2022-03-01',
                    'is_current'  => false,
                    'description' => "- Chạy Performance Marketing (Facebook Ads, Google Ads) cho các campaign Shopee 9.9, 11.11, 12.12.\n- ROAS trung bình đạt 8x, tối ưu CPA giảm 30% so với cùng kỳ.\n- Phân tích dữ liệu user behavior bằng Mixpanel để tối ưu funnel chuyển đổi.",
                    'order_index' => 2,
                    'created_at'  => now(), 'updated_at' => now(),
                ],
                [
                    'resume_id'   => $resume3->id,
                    'company'     => 'Công ty CP Quảng cáo Trí Tuệ',
                    'position'    => 'Marketing Executive',
                    'start_date'  => '2019-08-01',
                    'end_date'    => '2020-05-01',
                    'is_current'  => false,
                    'description' => "- Triển khai Social Media cho 5 khách hàng trong lĩnh vực F&B và bất động sản.\n- Content Creator: viết bài, thiết kế banner cơ bản bằng Canva.",
                    'order_index' => 3,
                    'created_at'  => now(), 'updated_at' => now(),
                ],
            ]);

            ResumeSkill::insert([
                ['resume_id' => $resume3->id, 'name' => 'Digital Marketing',        'level' => 90, 'order_index' => 1, 'created_at' => now(), 'updated_at' => now()],
                ['resume_id' => $resume3->id, 'name' => 'Facebook / TikTok Ads',    'level' => 90, 'order_index' => 2, 'created_at' => now(), 'updated_at' => now()],
                ['resume_id' => $resume3->id, 'name' => 'Google Ads',               'level' => 90, 'order_index' => 3, 'created_at' => now(), 'updated_at' => now()],
                ['resume_id' => $resume3->id, 'name' => 'Brand Management',         'level' => 90, 'order_index' => 4, 'created_at' => now(), 'updated_at' => now()],
                ['resume_id' => $resume3->id, 'name' => 'SEO / Content Marketing',  'level' => 60,  'order_index' => 5, 'created_at' => now(), 'updated_at' => now()],
                ['resume_id' => $resume3->id, 'name' => 'Google Analytics 4',       'level' => 90, 'order_index' => 6, 'created_at' => now(), 'updated_at' => now()],
                ['resume_id' => $resume3->id, 'name' => 'PowerPoint / Keynote',     'level' => 90, 'order_index' => 7, 'created_at' => now(), 'updated_at' => now()],
                ['resume_id' => $resume3->id, 'name' => 'Quản lý đội nhóm',         'level' => 90, 'order_index' => 8, 'created_at' => now(), 'updated_at' => now()],
            ]);

            ResumeProject::insert([
                [
                    'resume_id'   => $resume3->id,
                    'name'        => 'Chiến dịch "Vươn Cao Việt Nam" - Vinamilk 2023',
                    'role'        => 'Campaign Lead',
                    'link'        => null,
                    'start_date'  => '2023-06-01',
                    'end_date'    => '2023-12-01',
                    'description' => "Chiến dịch toàn quốc nhằm nâng cao nhận thức về dinh dưỡng trẻ em. KPI đạt 130% — 50M+ impressions, 5M+ engagements. Giải Bạc tại Vietnam Digital Awards 2023.",
                    'order_index' => 1,
                    'created_at'  => now(), 'updated_at' => now(),
                ],
                [
                    'resume_id'   => $resume3->id,
                    'name'        => 'Shopee 11.11 Campaign 2021',
                    'role'        => 'Performance Marketing Lead',
                    'link'        => null,
                    'start_date'  => '2021-10-01',
                    'end_date'    => '2021-11-30',
                    'description' => "Quản lý budget 2 tỷ cho chiến dịch 11.11. Doanh thu đạt 145% so với cùng kỳ 2020. ROAS: 9.5x.",
                    'order_index' => 2,
                    'created_at'  => now(), 'updated_at' => now(),
                ],
            ]);

            ResumeLanguage::insert([
                ['resume_id' => $resume3->id, 'language' => 'Tiếng Việt', 'proficiency' => 'Bản ngữ',    'created_at' => now(), 'updated_at' => now()],
                ['resume_id' => $resume3->id, 'language' => 'Tiếng Anh',  'proficiency' => 'IELTS 7.0',  'created_at' => now(), 'updated_at' => now()],
            ]);

            ResumeSocialLink::insert([
                ['resume_id' => $resume3->id, 'platform' => 'LinkedIn', 'url' => 'https://linkedin.com/in/tran-thi-bich', 'created_at' => now(), 'updated_at' => now()],
                ['resume_id' => $resume3->id, 'platform' => 'Facebook', 'url' => 'https://facebook.com/tranthibili',      'created_at' => now(), 'updated_at' => now()],
            ]);
        }

        // -------------------------------------------------------------------
        // CV #4 — Lê Minh Đức — Fresher Data Analyst
        // -------------------------------------------------------------------
        $resume4 = Resume::firstOrCreate(
            ['slug' => 'le-minh-duc-data-analyst'],
            [
                'user_id'       => $user3->id,
                'template_id'   => $template1->id,
                'title'         => 'CV Fresher Data Analyst',
                'full_name'     => 'Lê Minh Đức',
                'job_title'     => 'Fresher Data Analyst',
                'email'         => 'le.minh.duc@gmail.com',
                'phone'         => '0977 888 123',
                'address'       => 'Quận Cầu Giấy, Hà Nội',
                'summary'       => 'Sinh viên năm 4 ngành Thống kê Kinh tế, ĐH Kinh tế Quốc dân. Có kinh nghiệm thực tập phân tích dữ liệu bán hàng tại doanh nghiệp F&B. Thành thạo Python (Pandas, Matplotlib), SQL và Power BI. Đam mê biến dữ liệu thành insight có giá trị để hỗ trợ ra quyết định kinh doanh.',
                'custom_styles' => json_encode(['primary_color' => '#0f766e']),
                'is_public'     => true,
                'section_order' => json_encode(['summary', 'education', 'experience', 'skills', 'projects', 'languages', 'social_links']),
            ]
        );

        if ($resume4->wasRecentlyCreated) {
            ResumeEducation::insert([
                [
                    'resume_id'   => $resume4->id,
                    'institution' => 'Đại học Kinh tế Quốc dân (NEU)',
                    'degree'      => 'Cử nhân Thống kê Kinh tế',
                    'start_date'  => '2021-09-01',
                    'end_date'    => null,
                    'is_current'  => true,
                    'description' => 'GPA: 3.5/4.0 (dự kiến tốt nghiệp tháng 06/2025). Học bổng khuyến tài học kỳ 1 năm 3.',
                    'order_index' => 1,
                    'created_at'  => now(), 'updated_at' => now(),
                ],
            ]);

            ResumeExperience::insert([
                [
                    'resume_id'   => $resume4->id,
                    'company'     => 'The Coffee House',
                    'position'    => 'Data Analyst Intern',
                    'start_date'  => '2024-06-01',
                    'end_date'    => '2024-09-01',
                    'is_current'  => false,
                    'description' => "- Phân tích dữ liệu bán hàng theo chuỗi 100+ cửa hàng bằng Python và SQL.\n- Xây dựng dashboard Power BI theo dõi doanh thu theo thời gian thực, giúp ban quản lý giảm 2 giờ báo cáo/tuần.\n- Phát hiện insight về khung giờ cao điểm, đề xuất điều chỉnh ca làm giúp tăng 12% hiệu suất.",
                    'order_index' => 1,
                    'created_at'  => now(), 'updated_at' => now(),
                ],
            ]);

            ResumeSkill::insert([
                ['resume_id' => $resume4->id, 'name' => 'Python (Pandas, NumPy, Matplotlib)', 'level' => 90, 'order_index' => 1, 'created_at' => now(), 'updated_at' => now()],
                ['resume_id' => $resume4->id, 'name' => 'SQL (MySQL, PostgreSQL)',              'level' => 90, 'order_index' => 2, 'created_at' => now(), 'updated_at' => now()],
                ['resume_id' => $resume4->id, 'name' => 'Power BI',                            'level' => 90, 'order_index' => 3, 'created_at' => now(), 'updated_at' => now()],
                ['resume_id' => $resume4->id, 'name' => 'Excel / Google Sheets',               'level' => 90, 'order_index' => 4, 'created_at' => now(), 'updated_at' => now()],
                ['resume_id' => $resume4->id, 'name' => 'Tableau',                             'level' => 30,     'order_index' => 5, 'created_at' => now(), 'updated_at' => now()],
                ['resume_id' => $resume4->id, 'name' => 'Machine Learning cơ bản (Scikit-learn)','level' => 30,  'order_index' => 6, 'created_at' => now(), 'updated_at' => now()],
            ]);

            ResumeProject::insert([
                [
                    'resume_id'   => $resume4->id,
                    'name'        => 'Phân tích xu hướng việc làm IT Việt Nam 2024',
                    'role'        => 'Solo Project',
                    'link'        => 'https://github.com/leminhduc/it-jobs-analysis',
                    'start_date'  => '2024-03-01',
                    'end_date'    => '2024-05-01',
                    'description' => "Crawl dữ liệu 10.000+ tin tuyển dụng từ TopCV, LinkedIn bằng Python Scrapy. Phân tích xu hướng kỹ năng, mức lương theo ngành, thể hiện bằng Plotly interactive charts.",
                    'order_index' => 1,
                    'created_at'  => now(), 'updated_at' => now(),
                ],
                [
                    'resume_id'   => $resume4->id,
                    'name'        => 'Dự báo doanh thu chuỗi F&B (Đồ án môn học)',
                    'role'        => 'Team Lead (4 người)',
                    'link'        => null,
                    'start_date'  => '2023-09-01',
                    'end_date'    => '2024-01-01',
                    'description' => "Xây dựng mô hình ARIMA và Prophet để dự báo doanh thu 30 ngày tới. MAPE đạt 8.2% trên tập test. Điểm đồ án: 9.5/10.",
                    'order_index' => 2,
                    'created_at'  => now(), 'updated_at' => now(),
                ],
            ]);

            ResumeLanguage::insert([
                ['resume_id' => $resume4->id, 'language' => 'Tiếng Việt', 'proficiency' => 'Bản ngữ',    'created_at' => now(), 'updated_at' => now()],
                ['resume_id' => $resume4->id, 'language' => 'Tiếng Anh',  'proficiency' => 'TOEIC 800',  'created_at' => now(), 'updated_at' => now()],
            ]);

            ResumeSocialLink::insert([
                ['resume_id' => $resume4->id, 'platform' => 'GitHub',    'url' => 'https://github.com/leminhduc',                 'created_at' => now(), 'updated_at' => now()],
                ['resume_id' => $resume4->id, 'platform' => 'LinkedIn',  'url' => 'https://linkedin.com/in/le-minh-duc-data',     'created_at' => now(), 'updated_at' => now()],
                ['resume_id' => $resume4->id, 'platform' => 'Kaggle',    'url' => 'https://kaggle.com/leminhduc',                 'created_at' => now(), 'updated_at' => now()],
            ]);
        }

        $this->command->info('✅ Seeding hoàn tất!');
        $this->command->table(
            ['Loại', 'Số lượng'],
            [
                ['Templates',    Template::count()],
                ['Users',        User::count()],
                ['Resumes',      Resume::count()],
                ['Educations',   ResumeEducation::count()],
                ['Experiences',  ResumeExperience::count()],
                ['Skills',       ResumeSkill::count()],
                ['Projects',     ResumeProject::count()],
                ['Languages',    ResumeLanguage::count()],
                ['Social Links', ResumeSocialLink::count()],
            ]
        );
    }
}
