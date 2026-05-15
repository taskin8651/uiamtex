<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WorkGalleryImage;
use Gate;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\Response;

class WorkGalleryImagesController extends Controller
{
    public function destroy(WorkGalleryImage $workGalleryImage)
    {
        abort_if(Gate::denies('work_gallery_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // delete physical file
        $path = public_path($workGalleryImage->image);
        if ($workGalleryImage->image && File::exists($path)) {
            File::delete($path);
        }

        $workGalleryImage->delete();

        return back()->with('message', 'Image deleted successfully.');
    }
}
