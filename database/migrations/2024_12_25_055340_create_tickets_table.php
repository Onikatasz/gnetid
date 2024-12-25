<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    // schema for the tickets table
    // tickets {
    //     id varchar pk
    //     client_id integer fk
    //     title varchar
    //     body text
    //     status ENUM("pending", "in_progress", "completed")
    //   }

    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained();
            $table->string('title');
            $table->text('body');
            $table->enum('status', ['pending', 'in_progress', 'completed']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
