<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('rank_members', function (Blueprint $table) {
            $table->id();
            $table->string('rank');
            $table->integer('min_points');
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
        DB::table('rank_members')->insert([
            ['rank' => 'Bronze', 'min_points' => 0],
            ['rank' => 'Silver', 'min_points' => 100],
            ['rank' => 'Gold', 'min_points' => 1000],
            ['rank' => 'Diamond', 'min_points' => 10000],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rank_members');
    }
};
