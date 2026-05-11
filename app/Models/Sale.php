<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'invoice_no',
        'customer_id',
        'sale_date',
        'subtotal',
        'discount',
        'tax',
        'tax_percent',
        'shipping',
        'total',
        'paid_amount',
        'due_amount',
        'payment_status',
        'payment_type',
        'note',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function returns()
    {
        return $this->hasMany(SaleReturn::class);
    }
}
