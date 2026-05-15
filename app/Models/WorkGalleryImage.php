<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkGalleryImage extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'work_gallery_images';

    protected $fillable = [
        'work_gallery_id',
        'image',
        'sort_order',
    ];

    public function gallery()
    {
        return $this->belongsTo(WorkGallery::class, 'work_gallery_id');
    }
}
