<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceEnquiry extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'service_enquiries';

    protected $fillable = [
        'premises_type',
        'service_required',
        'name',
        'phone',
        'email',
        'city',
        'message',
        'status',
    ];

    public const STATUS_SELECT = [
        'new'       => 'New',
        'contacted' => 'Contacted',
        'closed'    => 'Closed',
    ];
}
