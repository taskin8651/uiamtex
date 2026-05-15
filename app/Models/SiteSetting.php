<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiteSetting extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'site_settings';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'site_name',
        'phone',
        'email',
        'address',
        'whatsapp',
        'footer_about',
        'map_embed',
        'facebook_url',
        'instagram_url',
        'linkedin',
        'youtube',
        'logo',
        'favicon',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
