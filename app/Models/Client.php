<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\ClientFactory> */
    use HasFactory;

    //Schema
    // client {
    //     id int pk
    //     name varchar
    //     phone varchar unique
    //     nik varchar
    //   }

    protected $fillable = [
        'name',
        'phone',
        'nik',
        'address',
    ];

    public function subscriptions()
    {
        return $this->hasOne(Subscription::class);
    }
}
