<?php
namespace App\Services\common;

use Maatwebsite\Excel\Facades\Excel;

class ExportService
{
    public function exportData($exporter, string $filename): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $filenameWithDate = $filename . '_' . date('Y_m_d') . '.xlsx';
        $response = Excel::download($exporter, $filenameWithDate, \Maatwebsite\Excel\Excel::XLSX);
        if (ob_get_contents()) ob_end_clean();
        return $response;
    }
}
