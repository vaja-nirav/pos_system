<?php

namespace App\Models;

use App\Traits\HasStore;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasStore;

    protected $fillable = [
        'store_id',
        'supplier_id',
        'invoice_no',
        'purchase_date',
        'subtotal',
        'tax',
        'discount',
        'total',
        'paid_amount',
        'due_amount',
        'payment_status',
        'status',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function items()
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public function returns()
    {
        return $this->hasMany(PurchaseReturn::class);
    }
}