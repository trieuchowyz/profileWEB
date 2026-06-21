<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chỉnh sửa CV</title>
    <style>
        body { display: flex; height: 100vh; margin: 0; font-family: sans-serif; background: #f3f4f6; }
        .editor-panel { width: 40%; background: #fff; padding: 20px; overflow-y: auto; border-right: 1px solid #ccc; }
        .preview-panel { width: 60%; padding: 20px; display: flex; justify-content: center; }
        .form-group { margin-bottom: 15px; }
        input, textarea { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .btn { background: #2563eb; color: #fff; padding: 10px; width: 100%; border: none; cursor: pointer; }
        iframe { width: 100%; max-width: 800px; height: 100%; border: none; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
    <div class="editor-panel">
        <h2>Trình Kiến Tạo CV</h2>
        <form>
            <div class="form-group"><label>Họ và Tên</label><input type="text" value="{{ $resume->full_name }}"></div>
            <div class="form-group"><label>Vị trí</label><input type="text" value="{{ $resume->job_title }}"></div>
            <div class="form-group"><label>Email</label><input type="email" value="{{ $resume->email }}"></div>
            <div class="form-group"><label>Giới thiệu</label><textarea rows="4">{{ $resume->summary }}</textarea></div>
            <button type="button" class="btn">Lưu CV</button>
        </form>
    </div>
    <div class="preview-panel">
        <iframe src="{{ route('cv.preview', $resume->slug) }}"></iframe>
    </div>
</body>
</html>