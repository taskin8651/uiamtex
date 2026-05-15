<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceProcessStep extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'service_process_steps';

    public const IS_ACTIVE_SELECT = [
        'yes' => 'YES',
        'no'  => 'NO',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'step_no',
        'title',
        'description',
        'sort_order',
        'is_active',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
