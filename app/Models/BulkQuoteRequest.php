<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BulkQuoteRequest extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'bulk_quote_requests';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'product',
        'variant',
        'qty',
        'company_name',
        'city',
        'phone',
        'email',
        'notes',
        'status',
        'admin_notes',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
