<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'addresses';

    public const IS_DEFAULT_SELECT = [
        'yes' => 'YES',
        'no'  => 'NO',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'user_id',
        'label',
        'line_1',
        'line_2',
        'city',
        'state',
        'pincode',
        'country',
        'is_default',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function user()
    {
        return $this->belongsTo(EndUser::class, 'user_id');
    }
}
