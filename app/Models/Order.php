<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'orders';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const STATUS_SELECT = [
        'processing' => 'Processing',
        'shipped'    => 'Shipped',
        'delivered'  => 'Delivered',
        'cancelled'  => 'Cancelled',
        'hold'       => 'Hold',
    ];

    protected $fillable = [
        'user_id',
        'order_no',
        'status',
        'subtotal',
        'shipping',
        'tax',
        'total',
        'payment_status',
        'payment_gateway',
        'txn',
        'address_snapshot',
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
