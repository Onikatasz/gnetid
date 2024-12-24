<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    /** @use HasFactory<\Database\Factories\SubscriptionPlanFactory> */
    use HasFactory;

    // Schema
    // subscription_plans {
    //     id int pk
    //     title varchar
    //     price int
    //     duration_days int
    //   }

    protected $fillable = [
        'title',
        'price',
        'duration_days',
    ];
}
