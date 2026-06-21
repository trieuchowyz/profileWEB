<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>CV - {{ $resume->full_name }}</title>
    <style>
        body { font-family: 'Arial', sans-serif; background: #fff; margin: 0; padding: 20px; }
        .cv-box { max-width: 800px; margin: 0 auto; display: flex; border: 1px solid #ccc; }
        .sidebar { width: 35%; background: #232b38; color: #fff; padding: 20px; }
        .main { width: 65%; padding: 20px; }
        h1 { color: #d4af37; margin-top: 0; }
        .sec-title { font-weight: bold; border-bottom: 2px solid #d4af37; margin-bottom: 10px; padding-bottom: 5px; text-transform: uppercase; }
        .sidebar .sec-title { border-bottom-color: #4a5568; }
        .item-title { font-weight: bold; }
        .item-sub { font-size: 0.9rem; color: #666; font-style: italic; }
    </style>
</head>
<body>
    <div class="cv-box">
        <div class="sidebar">
            <div class="sec-title">Liên Hệ</div>
            <p>📧 {{ $resume->email }}</p>
            <p>📞 {{ $resume->phone }}</p>

            <div class="sec-title" style="margin-top: 20px;">Kỹ Năng</div>
            @foreach($resume->skills as $skill)
                <p>⭐ {{ $skill->name }} ({{ $skill->level }}%)</p>
            @endforeach
        </div>

        <div class="main">
            <h1>{{ $resume->full_name }}</h1>
            <h3 style="color: #666; margin-top: -10px;">{{ $resume->job_title }}</h3>

            <div class="sec-title">Kinh Nghiệm</div>
            @foreach($resume->experiences as $exp)
                <div style="margin-bottom: 15px;">
                    <div class="item-title">{{ $exp->position }}</div>
                    <div class="item-sub">{{ $exp->company }}</div>
                    <p style="font-size: 0.9rem;">{{ $exp->description }}</p>
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>