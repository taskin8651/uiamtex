<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HomeHero extends Model
{
    use SoftDeletes;

    protected $table = 'home_heroes';

    protected $fillable = [
        'badge_icon',
        'badge_text',
        'title_line_1',
        'title_highlight',
        'subtitle',
        'cta_text',
        'cta_url',
        'meta_text',
        'desktop_image',
        'mobile_image',
        'sort_order',
        'is_active',
    ];
}
