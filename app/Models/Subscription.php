<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    /** @use HasFactory<\Database\Factories\SubscriptionFactory> */
    use HasFactory;

    // Schema
    // subscriptions {
    //     id int pk
    //     client_id int fk
    //     subscription_plan_id int fk
    //     username varchar unique
    //     password varchar
    //     start_date date
    //     end_date date
    //   }
      

    protected $fillable = [
        'client_id',
        'subscription_plan_id',
        'username',
        'password',
        'start_date',
        'end_date',
        'next_billing_date',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

}
