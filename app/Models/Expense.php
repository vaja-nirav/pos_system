<?php

namespace App\Models;

use App\Traits\HasStore;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasStore;

    protected $fillable = [
        'store_id',
        'expense_category_id',
        'title',
        'amount',
        'expense_date',
        'note',
        'status'
    ];

    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id');
    }
}
