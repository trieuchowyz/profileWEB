<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $resume->title }} - {{ $resume->full_name }}</title>
    
    @php
        // Cấu hình thứ tự mặc định nếu chưa được thiết lập trong DB
        $defaultOrder = ['summary', 'experiences', 'projects', 'educations', 'skills', 'languages', 'social_links'];
        $sectionOrder = $resume->section_order ?? $defaultOrder;
        
        // Gộp cấu hình styles mặc định của hệ thống với cá nhân hóa của User
        $defaultStyles = $resume->templates->default_styles ?? [
            'primary_color' => '#2563eb', 
            'heading_font' => 'Arial, sans-serif'
        ];
        $styles = array_merge($defaultStyles, $resume->custom_styles ?? []);
    @endphp

    <style>
        :root {
            --primary-color: {{ $styles['primary_color'] ?? '#2563eb' }};
            --heading-font: {!! $styles['heading_font'] ?? 'Arial, sans-serif' !!};
            --body-font: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: var(--body-font); color: #333; line-height: 1.5; background: #fff; padding: 0; }
        
        .cv-container { width: 100%; min-height: 100%; background: #fff; }
        
        /* Header */
        .cv-header { background-color: var(--primary-color); color: #fff; padding: 40px 30px; text-align: left; display: flex; align-items: center; gap: 25px; }
        .avatar-wrap { width: 100px; height: 100px; border-radius: 50%; overflow: hidden; border: 3px solid #fff; background: #eee; flex-shrink: 0; }
        .avatar-wrap img { width: 100%; height: 100%; object-fit: cover; }
        .header-info h1 { font-family: var(--heading-font); font-size: 26px; text-transform: uppercase; margin-bottom: 5px; letter-spacing: 1px; }
        .header-info .job-title { font-size: 16px; font-weight: 500; opacity: 0.95; text-transform: uppercase; }
        
        /* Contact info under header */
        .contact-bar { background: #f8fafc; padding: 12px 30px; display: flex; flex-wrap: wrap; gap: 20px; font-size: 13px; color: #475569; border-bottom: 1px solid #e2e8f0; }
        .contact-bar span { display: flex; align-items: center; gap: 5px; }

        /* Sections Layout */
        .cv-body { padding: 30px; }
        .cv-section { margin-bottom: 28px; }
        .cv-section-title { 
            font-family: var(--heading-font); 
            color: var(--primary-color); 
            font-size: 18px; 
            border-bottom: 2px solid var(--primary-color); 
            padding-bottom: 4px; 
            margin-bottom: 15px; 
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        /* Items detail style */
        .cv-item { margin-bottom: 16px; page-break-inside: avoid; }
        .cv-item-header { display: flex; justify-content: space-between; align-items: baseline; font-weight: bold; font-size: 14px; color: #1e293b; }
        .cv-item-sub { display: flex; justify-content: space-between; align-items: baseline; font-style: italic; color: #64748b; font-size: 13px; margin-bottom: 6px; }
        .cv-item-desc { font-size: 13.5px; color: #334155; white-space: pre-line; text-align: justify; }

        /* Grid Lists for small items (Skills, Languages, Links) */
        .grid-list { display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; list-style: none; }
        .grid-list li { font-size: 13.5px; color: #334155; display: flex; align-items: center; justify-content: space-between; padding-right: 20px; }
        .grid-list li strong { color: #1e293b; }
        .social-links-list { display: flex; flex-wrap: wrap; gap: 15px; list-style: none; font-size: 13.5px; }
        .social-links-list a { color: var(--primary-color); text-decoration: none; font-weight: 500; }
    </style>
</head>
<body>

    <div class="cv-container">
        <div class="cv-header">
            @if($resume->avatar)
                <div class="avatar-wrap">
                    <img src="{{ asset('storage/' . $resume->avatar) }}" alt="Avatar">
                </div>
            @endif
            <div class="header-info">
                <h1>{{ $resume->full_name ?? 'Họ và Tên' }}</h1>
                <div class="job-title">{{ $resume->job_title ?? 'Vị trí ứng tuyển' }}</div>
            </div>
        </div>

        <div class="contact-bar">
            @if($resume->phone) <span><strong>ĐT:</strong> {{ $resume->phone }}</span> @endif
            @if($resume->email) <span><strong>Email:</strong> {{ $resume->email }}</span> @endif
            @if($resume->address) <span><strong>Địa chỉ:</strong> {{ $resume->address }}</span> @endif
        </div>

        <div class="cv-body">
            @foreach($sectionOrder as $section)
                
                @if($section === 'summary' && !empty($resume->summary))
                    <div class="cv-section">
                        <h2 class="cv-section-title">Giới thiệu bản thân</h2>
                        <div class="cv-item-desc">{{ $resume->summary }}</div>
                    </div>
                @endif

                @if($section === 'experiences' && $resume->experiences->isNotEmpty())
                    <div class="cv-section">
                        <h2 class="cv-section-title">Kinh nghiệm làm việc</h2>
                        @foreach($resume->experiences as $exp)
                            <div class="cv-item">
                                <div class="cv-item-header">
                                    <span>{{ $exp->position }}</span>
                                    <span>{{ $exp->company }}</span>
                                </div>
                                <div class="cv-item-sub">
                                    <span>Thờ gian: {{ $exp->start_date ? $exp->start_date->format('m/Y') : '' }} - {{ $exp->is_current ? 'Hiện tại' : ($exp->end_date ? $exp->end_date->format('m/Y') : '') }}</span>
                                </div>
                                @if($exp->description)
                                    <div class="cv-item-desc">{{ $exp->description }}</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif

                @if($section === 'projects' && $resume->projects->isNotEmpty())
                    <div class="cv-section">
                        <h2 class="cv-section-title">Dự án thực tế</h2>
                        @foreach($resume->projects as $project)
                            <div class="cv-item">
                                <div class="cv-item-header">
                                    <span>{{ $project->name }}</span>
                                    <span>Vai trò: {{ $project->role }}</span>
                                </div>
                                <div class="cv-item-sub">
                                    <span>{{ $project->start_date ? $project->start_date->format('m/Y') : '' }} - {{ $project->end_date ? $project->end_date->format('m/Y') : 'Hiện tại' }}</span>
                                    @if($project->link)
                                        <span class="cv-item-desc"><strong>Link:</strong> {{ $project->link }}</span>
                                    @endif
                                </div>
                                @if($project->description)
                                    <div class="cv-item-desc">{{ $project->description }}</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif

                @if($section === 'educations' && $resume->educations->isNotEmpty())
                    <div class="cv-section">
                        <h2 class="cv-section-title">Học vấn</h2>
                        @foreach($resume->educations as $edu)
                            <div class="cv-item">
                                <div class="cv-item-header">
                                    <span>{{ $edu->degree }}</span>
                                    <span>{{ $edu->institution }}</span>
                                </div>
                                <div class="cv-item-sub">
                                    <span>Thời gian: {{ $edu->start_date ? $edu->start_date->format('m/Y') : '' }} - {{ $edu->is_current ? 'Đang học' : ($edu->end_date ? $edu->end_date->format('m/Y') : '') }}</span>
                                </div>
                                @if($edu->description)
                                    <div class="cv-item-desc">{{ $edu->description }}</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif

                @if($section === 'skills' && $resume->skills->isNotEmpty())
                    <div class="cv-section">
                        <h2 class="cv-section-title">Kỹ năng</h2>
                        <ul class="grid-list">
                            @foreach($resume->skills as $skill)
                                <li>
                                    <strong>{{ $skill->name }}</strong>
                                    <span>{{ $skill->level }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if($section === 'languages' && $resume->languages->isNotEmpty())
                    <div class="cv-section">
                        <h2 class="cv-section-title">Ngôn ngữ</h2>
                        <ul class="grid-list">
                            @foreach($resume->languages as $lang)
                                <li>
                                    <strong>{{ $lang->language }}</strong>
                                    <span>{{ $lang->proficiency }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if($section === 'social_links' && $resume->socialLinks->isNotEmpty())
                    <div class="cv-section">
                        <h2 class="cv-section-title">Liên kết thành viên</h2>
                        <ul class="social-links-list">
                            @foreach($resume->socialLinks as $link)
                                <li>
                                    <strong>{{ $link->platform }}:</strong> 
                                    <a href="{{ $link->url }}" target="_blank">{{ $link->url }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

            @endforeach
        </div>
    </div>

</body>
</html>