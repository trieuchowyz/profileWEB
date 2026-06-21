<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Template;
use Illuminate\Support\Str;

class TemplateSeeder extends Seeder
{
    public function run()
    {
        Template::updateOrCreate(
            ['slug' => Str::slug('Elegant Gold')],
            [
                'name' => 'Elegant Gold',
                'thumbnail' => 'templates/elegant.png',
                'view_path' => 'cv.template1', // Cực kỳ quan trọng: Trỏ đúng vào thư mục resources/views/cv/template1.blade.php
                'default_styles' => ['primary_color' => '#d4af37'],
                'is_active' => true,
            ]
        );
    }
}