<?php

namespace App\Models;

use Config;
use App\Models\Model;

class ProductInfo extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'desc', 'title', 'bdesc', 'btitle'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product_info';
}