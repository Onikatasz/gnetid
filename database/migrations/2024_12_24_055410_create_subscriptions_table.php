<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    // Schema
    // subscriptions {
    //     id int pk
    //     client_id int fk
    //     subscription_plan_id int fk
    //     username varchar unique
    //     password varchar
    //     subscribe_at date
    //     start_date date
    //     end_date date
    //   }

    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id()->from(10000000000);
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subscription_plan_id')->constrained()->cascadeOnDelete();
            $table->string('username')->unique();
            $table->string('password');
            $table->date('subscribe_at');
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
