<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Supplier extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'company_name',
        'gst_number',
        'address',
        'city',
        'state',
        'zip_code',
        'status',
    ];
}
