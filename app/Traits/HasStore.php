<?php

namespace App\Traits;

use App\Models\Store;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Session;

trait HasStore
{
    protected static function bootHasStore()
    {
        static::addGlobalScope('store', function (Builder $builder) {
            if (Session::has('active_store_id')) {
                $builder->where('store_id', Session::get('active_store_id'));
            }
        });

        static::creating(function ($model) {
            if (!$model->store_id && Session::has('active_store_id')) {
                $model->store_id = Session::get('active_store_id');
            }
        });
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
