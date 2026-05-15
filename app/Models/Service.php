<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'services';

    public const IS_ACTIVE_SELECT = [
        'yes' => 'YES',
        'no'  => 'NO',
    ];

    protected $fillable = [
        'category',
        'title',
        'short_description',
        'cta_label',
        'sort_order',
        'is_active',
    ];

    public function features()
    {
        return $this->hasMany(ServiceFeature::class, 'service_id')->orderBy('sort_order');
    }
}
