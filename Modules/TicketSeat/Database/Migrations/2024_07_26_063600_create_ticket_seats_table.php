<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketSeatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_seats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seat_showtime_status_id')->constrained('seat_showtime_status')->onDelete('cascade');
            $table->foreignId('bill_id')->constrained('bills')->onDelete('cascade');
            $table->foreignId('movie_id')->constrained();
            $table->foreignId('room_id')->constrained();
            $table->foreignId('cinema_id')->constrained();
            $table->foreignId('showing_release_id')->constrained();
            $table->timestamp('time_start');
            $table->decimal('price', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticket_seats');
    }
}
