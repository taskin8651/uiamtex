<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Download;
use App\Models\DownloadRequest;
use Illuminate\Http\Request;

class DownloadRequestController extends Controller
{
    public function unlock(Request $request)
    {
        $data = $request->validate([
            'download_id' => ['required','integer','exists:downloads,id'],
            'name'        => ['required','string','max:255'],
            'phone'       => ['required','string','max:30'],
            'email'       => ['nullable','email','max:255'],
            'company'     => ['nullable','string','max:255'],
            'city'        => ['nullable','string','max:255'],
            'purpose'     => ['nullable','string','max:255'],
            'message'     => ['nullable','string'],
        ]);

        $download = Download::findOrFail($data['download_id']);

        // Store lead
        DownloadRequest::create([
            'download_id' => $download->id,
            'download'    => $download->title, // optional legacy
            ...$data,
        ]);

        // Return file url
        $file = $download->file; // Spatie Media
        if (!$file) {
            return response()->json([
                'ok' => false,
                'message' => 'File not attached by admin.',
            ], 422);
        }

        return response()->json([
            'ok' => true,
            'download_id' => $download->id,
            'file_url' => $file->getUrl(),
            'title' => $download->title,
        ]);
    }
}
