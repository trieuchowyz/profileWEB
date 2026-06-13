<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Settings
    |--------------------------------------------------------------------------
    |
    | Cấu hình cho thư viện barryvdh/laravel-dompdf
    | Tối ưu cho web tiếng Việt, host thật
    |
    */

    'show_warnings' => false, // Tắt warning trong production

    'orientation' => 'portrait',

    'defines' => [

        /*
        |--------------------------------------------------------------------------
        | Font
        |--------------------------------------------------------------------------
        */

        // Thư mục chứa font tùy chỉnh (để thêm Roboto, Be Vietnam Pro, v.v.)
        'DOMPDF_FONT_DIR' => storage_path('fonts/'),

        // Cache font đã xử lý → tăng tốc render lần sau
        'DOMPDF_FONT_CACHE' => storage_path('fonts/'),

        // Thư mục cache tạm cho PDF
        'DOMPDF_TEMP_DIR' => sys_get_temp_dir(),

        // Thư mục chứa thư viện dompdf nội bộ
        'DOMPDF_CHROOT' => realpath(base_path()),

        /*
        |--------------------------------------------------------------------------
        | Font mặc định — DejaVu Sans hỗ trợ Unicode/tiếng Việt out-of-the-box
        | Nếu bạn đã cài font riêng (Roboto, Be Vietnam...) thì đổi ở đây
        |--------------------------------------------------------------------------
        */
        'DOMPDF_DEFAULT_FONT' => 'DejaVu Sans',

        /*
        |--------------------------------------------------------------------------
        | Kích thước giấy & DPI
        |--------------------------------------------------------------------------
        */
        'DOMPDF_DEFAULT_PAPER_SIZE'        => 'a4',
        'DOMPDF_DEFAULT_PAPER_ORIENTATION' => 'portrait',

        // DPI càng cao → PDF càng sắc nét, nhưng render chậm hơn
        // 150 là điểm cân bằng tốt cho web thật
        'DOMPDF_DPI' => 150,

        /*
        |--------------------------------------------------------------------------
        | Image & Remote
        |--------------------------------------------------------------------------
        */

        // Cho phép load ảnh từ URL bên ngoài (avatar, logo...)
        // Cần bật nếu bạn lưu ảnh trên S3, Cloudinary, v.v.
        'DOMPDF_ENABLE_REMOTE' => true,

        // Giới hạn kích thước ảnh inline (base64) — 30MB
        'DOMPDF_MAX_IMAGE_SIZE' => 30 * 1024 * 1024,

        /*
        |--------------------------------------------------------------------------
        | HTML & CSS
        |--------------------------------------------------------------------------
        */

        // Bật HTML5 parser — xử lý tốt hơn với Blade template hiện đại
        'DOMPDF_ENABLE_HTML5PARSER' => true,

        // Bật CSS float (dùng layout 2 cột trong CV)
        'DOMPDF_ENABLE_CSS_FLOAT' => true,

        // Bật font subsetting → giảm kích thước file PDF đầu ra
        'DOMPDF_ENABLE_FONTSUBSETTING' => true,

        // Tắt PHP trong template (bảo mật production)
        'DOMPDF_ENABLE_PHP' => false,

        // Bật JavaScript (thường không cần cho PDF tĩnh)
        'DOMPDF_ENABLE_JAVASCRIPT' => false,

        /*
        |--------------------------------------------------------------------------
        | Bảo mật — quan trọng khi host thật
        |--------------------------------------------------------------------------

        // Protocol được phép load (http/https)
        // Nếu chỉ dùng HTTPS thì nên để mảng này chỉ có 'https://'
        'ALLOWED_PROTOCOLS' => [
            'http://'  => ['rules' => []],
            'https://' => ['rules' => []],
            'file://'  => ['rules' => []],
        ],

        /*
        |--------------------------------------------------------------------------
        | Hiệu năng
        |--------------------------------------------------------------------------
        */

        // Bật cache internal của dompdf
        'DOMPDF_ENABLE_CACHE' => true,

        // Log render errors vào Laravel log (hữu ích khi debug)
        'DOMPDF_LOG_OUTPUT_FILE' => storage_path('logs/dompdf.log'),

        // Giới hạn đệ quy khi parse HTML phức tạp
        'DOMPDF_AUTOLOAD_PREPEND' => false,
    ],

];
