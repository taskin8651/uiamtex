<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Product extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, Auditable, HasFactory;

    public $table = 'products';

    protected $appends = [
        'main_image',
        'brochure_pdf',
    ];

    public const IS_ACTIVE_SELECT = [
        'yes' => 'YES',
        'no'  => 'NO',
    ];

    public const IS_FEATURED_SELECT = [
        'no'  => 'NO',
        'yes' => 'YES',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const BADGE_SELECT = [
        'New'         => 'New',
        'Best Seller' => 'Best Seller',
    ];

    protected $fillable = [
        'select_category_id',
        'name',
        'slug',
        'short_desc',
        'description',
        'base_price',
        'compare_price',
        'badge',
        'dispatch_text',
        'rating_avg',
        'rating_count',
        'sku',
        'is_featured',
        'is_active',
        'pdp_tags',
        'pdp_pointers',
        'pdp_key_highlights',
        'pdp_works_on',
        'pdp_recommended_for_left',
        'pdp_recommended_for_right',
        'pdp_available_sizes',
        'pdp_available_variants',
        'pdp_tech_table',
        'created_at',
        'updated_at',
        'deleted_at',

    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function select_category()
    {
        return $this->belongsTo(Category::class, 'select_category_id');
    }

    public function getMainImageAttribute()
    {
        $file = $this->getMedia('main_image')->last();
        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }

    public function getBrochurePdfAttribute()
    {
        return $this->getMedia('brochure_pdf')->last();
    }

    protected $casts = [
        'pdp_tags' => 'array',
        'pdp_pointers' => 'array',
        'pdp_key_highlights' => 'array',
        'pdp_works_on' => 'array',
        'pdp_recommended_for_left' => 'array',
        'pdp_recommended_for_right' => 'array',
        'pdp_tech_table' => 'array',
    ];

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'select_product_id');
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'select_product_id');
    }

    public function defaultVariant()
    {
        return $this->hasOne(ProductVariant::class, 'select_product_id')
            ->where('is_default', 'yes');
    }


}
