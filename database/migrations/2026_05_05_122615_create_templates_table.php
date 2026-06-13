<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // database/migrations/2026_05_05_000001_create_templates_table.php
        Schema::create('templates', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Tên mẫu (VD: Mẫu Hiện Đại, Mẫu Tối Giản)
            $table->string('slug')->unique(); // Đường dẫn thân thiện
            $table->string('thumbnail')->nullable(); // Ảnh preview của mẫu
            $table->string('view_path'); // Tên file blade view (VD: 'resumes.templates.modern')
            $table->json('default_styles')->nullable(); // Lưu cấu hình CSS mặc định (Màu sắc, font chữ)
            $table->boolean('is_active')->default(true); // Trạng thái Ẩn/Hiện
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
