<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /** @use HasFactory<\Database\Factories\ClientFactory> */
    use HasFactory;

    //Schema
    // client {
    //     id int pk
    //     name varchar
    //     phone_number varchar unique
    //     nik varchar
    //     is_subscribed bool
    //   }

    protected $fillable = [
        'name',
        'phone_number',
        'nik',
        'address',
        'is_subscribed',
    ];

    protected $casts = [
        'is_subscribed' => 'boolean',
    ];

    // public function subscription()
    // {
    //     return $this->hasOne(Subscription::class);
    // }
}
