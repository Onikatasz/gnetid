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
    //     end_date timestamp
    //   }

    protected $fillable = [
        'client_id',
        'subscription_plan_id',
        'end_date',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function subscriptionPlan()
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }

    public function isActive()
    {
        return now()->lessThanOrEqualTo($this->end_date);
    }

    public function scopeActive($query)
    {
        return $query->where('end_date', '>=', now());
    }

    public function scopeInactive($query)
    {
        return $query->where('end_date', '<', now());
    }

    public function scopeEndingSoon($query)
    {
        return $query->where('end_date', '<', now()->addDays(7));
    }

    public function scopeEndingAfter($query, $date)
    {
        return $query->where('end_date', '>', $date);
    }

    public function scopeEndingBefore($query, $date)
    {
        return $query->where('end_date', '<', $date);
    }

    public function scopeEndingBetween($query, $startDate, $endDate)
    {
        return $query->whereBetween('end_date', [$startDate, $endDate]);
    }

    public function scopeEndingOn($query, $date)
    {
        return $query->whereDate('end_date', $date);
    }

}
