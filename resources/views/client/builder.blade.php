<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa CV Trực Tiếp</title>
    <style>
        /* Nền tối, căn giữa tờ A4 */
        body { background: #cbd5e1; display: flex; justify-content: center; padding: 40px 0; font-family: Arial, sans-serif; margin: 0; }
        
        /* Khung giấy A4 */
        .cv-paper { width: 210mm; min-height: 297mm; background: white; padding: 50px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); }
        
        /* Hiệu ứng khi rê chuột vào chữ có thể sửa */
        [contenteditable="true"] { outline: none; border-radius: 4px; padding: 2px 4px; transition: background 0.2s, box-shadow 0.2s; }
        [contenteditable="true"]:hover { background: #f1f5f9; box-shadow: 0 0 0 1px #cbd5e1; cursor: text; }
        [contenteditable="true"]:focus { background: #fff; box-shadow: 0 0 0 2px #3b82f6; }
        
        /* Layout CV cơ bản */
        .cv-header { border-bottom: 3px solid #2563eb; padding-bottom: 20px; margin-bottom: 30px; text-align: center; }
        .cv-name { font-size: 36px; font-weight: bold; color: #1e293b; text-transform: uppercase; margin-bottom: 5px; }
        .cv-job { font-size: 18px; color: #2563eb; text-transform: uppercase; letter-spacing: 2px; }
        
        .cv-section { margin-bottom: 25px; }
        .cv-section-title { font-size: 18px; font-weight: bold; color: #2563eb; text-transform: uppercase; margin-bottom: 15px; }
        .cv-text { font-size: 14.5px; color: #334155; line-height: 1.6; }

        /* Nút lưu nổi ở góc phải */
        .btn-floating-save { position: fixed; bottom: 30px; right: 30px; padding: 15px 30px; background: #2563eb; color: white; border: none; border-radius: 50px; font-size: 16px; font-weight: bold; cursor: pointer; box-shadow: 0 4px 15px rgba(37, 99, 235, 0.4); transition: 0.2s; }
        .btn-floating-save:hover { background: #1d4ed8; transform: translateY(-2px); }
    </style>
</head>
<body>

    <div class="cv-paper">
        
        <div class="cv-header">
            <div class="cv-name" contenteditable="true" id="edit-name">{{ $resume->full_name ?? 'NHẬP HỌ TÊN CỦA BẠN' }}</div>
            <div class="cv-job" contenteditable="true" id="edit-job">{{ $resume->job_title ?? 'Vị trí ứng tuyển' }}</div>
        </div>

        <div class="cv-section">
            <div class="cv-section-title">GIỚI THIỆU BẢN THÂN</div>
            <div class="cv-text" contenteditable="true" id="edit-summary">
                {{ $resume->summary ?? 'Click vào đây để gõ đoạn giới thiệu bản thân của bạn. Bạn có thể xóa dòng này đi và gõ nội dung mới...' }}
            </div>
        </div>

        <div class="cv-section">
            <div class="cv-section-title">KINH NGHIỆM LÀM VIỆC</div>
            <div class="cv-text" contenteditable="true">
                <strong>Công ty TNHH Phần Mềm (2024 - Hiện tại)</strong><br>
                - Vị trí: Lập trình viên Front-end<br>
                - Công việc: Click vào đây để gõ trực tiếp công việc của bạn.
            </div>
        </div>

    </div>

    <button class="btn-floating-save" onclick="saveDirectly()">💾 Lưu CV</button>

    <script>
        function saveDirectly() {
            // Lấy chữ trực tiếp từ các khối trên CV
            const name = document.getElementById('edit-name').innerText.trim();
            const job = document.getElementById('edit-job').innerText.trim();
            const summary = document.getElementById('edit-summary').innerText.trim();

            const data = {
                _method: 'PATCH',
                full_name: name,
                job_title: job,
                summary: summary
            };

            // Bắn API lưu vào Database của bạn
            fetch(`/cv/resumes/{{ $resume->id }}`, {
                method: 'POST', 
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(data)
            })
            .then(res => res.json())
            .then(result => {
                alert('Tuyệt vời! Đã lưu thành công vào Database.');
            })
            .catch(err => {
                alert('Lỗi lưu dữ liệu. Đảm bảo bạn đang mở đúng link CV thật, không phải link test.');
            });
        }
    </script>
</body>
</html>