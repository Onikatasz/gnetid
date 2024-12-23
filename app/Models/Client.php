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
    //     is_subscribe bool
    //   }

    protected $fillable = [
        'name',
        'phone_number',
        'nik',
        'is_subscribe',
    ];

    protected $casts = [
        'is_subscribe' => 'boolean',
    ];

    // public function subscription()
    // {
    //     return $this->hasOne(Subscription::class);
    // }
}
