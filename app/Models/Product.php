<?php

namespace App\Models;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Traits\HasStore;

class Product extends Model implements HasMedia
{
    use InteractsWithMedia, HasStore;

    protected $fillable = [
        'store_id',
        'category_id',
        'brand_id',
        'unit_id',
        'name',
        'slug',
        'sku',
        'barcode',
        'cost_price',
        'selling_price',
        'stock_alert',
        'description',
        'status',
        'opening_stock',
        'current_stock',
        'supplier_id',
        'warehouse_id',
        'product_type',
        'variations',
    ];

    protected $casts = [
        'variations' => 'array',
    ];

    // Relations
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function purchaseReturnItems()
    {
        return $this->hasMany(PurchaseReturnItem::class);
    }

    public function saleReturnItems()
    {
        return $this->hasMany(SaleReturnItem::class);
    }
}
