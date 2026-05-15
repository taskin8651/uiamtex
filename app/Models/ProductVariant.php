<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariant extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'product_variants';

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
        'select_product_id',
        'capacity_label',
        'finish_label',
        'sku',
        'price',
        'compare_price',
        'stock_qty',
        'is_default',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function select_product()
    {
        return $this->belongsTo(Product::class, 'select_product_id');
    }
}
