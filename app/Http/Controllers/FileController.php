<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Report;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    /**
     * Serve a report image from private storage.
     */
    public function reportImage(Report $report, string $filename)
    {
        $path = 'images/reports/' . $report->id . '/' . $filename;

        if (!Storage::disk('local')->exists($path)) {
            abort(404);
        }

        return Storage::disk('local')->response($path);
    }

    /**
     * Serve a client thumbnail from private storage.
     */
    public function clientThumbnail(Client $client)
    {
        if (!$client->thumbnail) {
            abort(404);
        }

        $path = 'images/clients/' . $client->thumbnail;

        if (!Storage::disk('local')->exists($path)) {
            abort(404);
        }

        return Storage::disk('local')->response($path);
    }

    /**
     * Serve a report PDF from private storage.
     */
    public function reportPdf(Report $report)
    {
        $report->loadMissing('pdf');

        $filePath = $report->pdf?->file_path;

        if (!$filePath || !Storage::disk('local')->exists($filePath)) {
            abort(404);
        }

        $downloadName = $report->pdf->file_name ?? basename($filePath);

        return Storage::disk('local')->download($filePath, $downloadName);
    }
}


