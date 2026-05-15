<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkGallery extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'work_galleries';

    public const IS_ACTIVE_SELECT = [
        'yes' => 'YES',
        'no'  => 'NO',
    ];

    protected $fillable = [
        'title',
        'image',
        'sort_order',
        'is_active',
    ];
}