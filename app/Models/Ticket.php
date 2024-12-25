<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    /** @use HasFactory<\Database\Factories\TicketFactory> */
    use HasFactory;

    // schema for the tickets table
    // tickets {
    //     id varchar pk
    //     client_id integer fk
    //     title varchar
    //     body text
    //     status ENUM("pending", "in_progress", "completed")
    //   }

    protected $fillable = [
        'title',
        'body',
        'status',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
