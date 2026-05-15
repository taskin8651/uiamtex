<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DownloadRequest extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'download_requests';

    protected $dates = ['created_at','updated_at','deleted_at'];

    protected $fillable = [
        'download_id',
        'download', // keep if you want legacy string
        'name',
        'phone',
        'email',
        'company',
        'city',
        'purpose',
        'message',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function downloadRelation()
    {
        return $this->belongsTo(Download::class, 'download_id');
    }
}
