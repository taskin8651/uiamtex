<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceFeature extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'service_features';

    protected $fillable = [
        'service_id',
        'feature_text',
        'sort_order',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}
