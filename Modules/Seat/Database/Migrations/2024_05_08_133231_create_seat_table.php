<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seats', function (Blueprint $table) {
            $table->id();
            $table->string('column');
            $table->string('row');
            $table->boolean('status')->default(false);
            $table->unsignedBigInteger('seat_type_id');
            $table->unique(['row', 'column', 'room_id']);
            $table->unsignedBigInteger('room_id');
            $table->foreign('seat_type_id')->references('id')->on('seat_types');
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
        Schema::dropIfExists('seat');
    }
};
