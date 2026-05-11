<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'country',
        'city',
        'zip_code',
        'status',
    ];
}
