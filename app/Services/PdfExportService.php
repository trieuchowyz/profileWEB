<?php

namespace App\Services;

use App\Models\Resume;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PdfExportService
{
    /**
     * Cấu hình mặc định cho DomPDF.
     */
    private array $defaultOptions = [];

    public function __construct()
    {
        $this->defaultOptions = [
            'defaultFont'             => 'DejaVu Sans', // Font hỗ trợ Unicode / tiếng Việt
            'isRemoteEnabled'         => true,          // Cho phép load ảnh từ URL (avatar)
            'isHtml5ParserEnabled'    => true,
            'isFontSubsettingEnabled' => true,
            'dpi'                     => 150,
            'defaultPaperSize'        => 'a4',
            'defaultPaperOrientation' => 'portrait',
            'chroot'                  => public_path(), // Bảo mật: giới hạn đọc file cục bộ
        ];
    }

    /**
     * Tạo PDF từ data của Resume và trả về dạng download.
     *
     * @param Resume $resume  Đã được eager-load đầy đủ các section
     * @param string $format  'download' | 'stream' | 'inline'
     * @return Response|StreamedResponse
     */
    public function export(Resume $resume, string $format = 'download'): Response|StreamedResponse
    {
        $pdf = $this->buildPdf($resume);

        $filename = $this->buildFilename($resume);

        return match ($format) {
            'stream'  => $pdf->stream($filename),
            'inline'  => $pdf->stream($filename),   // Hiện thị trên browser
            default   => $pdf->download($filename),  // Buộc tải về
        };
    }

    /**
     * Tạo raw PDF content (dạng string) — dùng khi cần lưu file vào Storage.
     *
     * @param Resume $resume
     * @return string  Raw PDF binary string
     */
    public function exportToString(Resume $resume): string
    {
        return $this->buildPdf($resume)->output();
    }

    // -------------------------------------------------------------------------
    // Private helpers
    // -------------------------------------------------------------------------

    /**
     * Khởi tạo DomPDF instance với cấu hình và render view.
     *
     * @param Resume $resume
     * @return \Barryvdh\DomPDF\PDF
     */
    private function buildPdf(Resume $resume): \Barryvdh\DomPDF\PDF
    {
        // Merge custom_styles từ Resume vào options nếu cần
        $options = $this->resolveOptions($resume);

        $pdf = Pdf::setOptions($options)
            ->setPaper('a4', 'portrait')
            ->loadView('pdf.resume', [
                'resume' => $resume,
            ]);

        return $pdf;
    }

    /**
     * Resolve DomPDF options, cho phép Resume override một số giá trị qua custom_styles.
     *
     * @param Resume $resume
     * @return array
     */
    private function resolveOptions(Resume $resume): array
    {
        $options = $this->defaultOptions;

        // Nếu custom_styles có khai báo orientation thì dùng
        if (! empty($resume->custom_styles['pdf_orientation'])
            && in_array($resume->custom_styles['pdf_orientation'], ['portrait', 'landscape'])
        ) {
            $options['defaultPaperOrientation'] = $resume->custom_styles['pdf_orientation'];
        }

        return $options;
    }

    /**
     * Tạo tên file PDF an toàn từ thông tin Resume.
     *
     * @param Resume $resume
     * @return string  VD: "nguyen-van-a-backend-developer-2024.pdf"
     */
    private function buildFilename(Resume $resume): string
    {
        $parts = array_filter([
            $resume->full_name ?? $resume->title,
            $resume->job_title,
            now()->format('Y'),
        ]);

        $name = implode('-', $parts);

        // Đổi sang ASCII-safe slug
        $name = preg_replace('/[^a-zA-Z0-9\-]/', '-', $name);
        $name = preg_replace('/-+/', '-', $name);
        $name = trim(strtolower($name), '-');

        return $name . '.pdf';
    }
}
