<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'braintree_id', 'price', 'active'
    ];

    protected $casts = [
        'active' => 'boolean'
    ];
}
