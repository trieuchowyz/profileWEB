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
        // database/migrations/2026_05_05_000002_create_resumes_table.php
        Schema::create('resumes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('template_id')->constrained(); // CV này dùng mẫu nào

            // Quản lý CV
            $table->string('title'); // Tên bản CV (VD: "CV Ứng tuyển Dev Web")
            $table->string('slug')->unique(); // Link public nếu user muốn share CV online

            // Thông tin cá nhân cơ bản (Profile)
            $table->string('full_name')->nullable();
            $table->string('job_title')->nullable(); // Vị trí ứng tuyển
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('avatar')->nullable();
            $table->text('summary')->nullable(); // Giới thiệu bản thân

            // Cột sức mạnh: Lưu tùy chỉnh giao diện của riêng User này (Ghi đè default_styles của template)
            $table->json('custom_styles')->nullable(); // Lưu color, font_size, font_family dưới dạng JSON

            $table->boolean('is_public')->default(false); // Cho phép nhà tuyển dụng xem link ko?
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resumes');
    }
};
