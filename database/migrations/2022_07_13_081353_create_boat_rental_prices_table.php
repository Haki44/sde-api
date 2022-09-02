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
        Schema::create('boat_rental_prices', function (Blueprint $table) {
            $table->id();
            $table->integer('price');
            $table->boolean('with_skipper');
            $table->foreignId('boat_id')->nullable()->constrained();
            $table->foreignId('period_id')->nullable()->constrained();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boat_rental_prices');
    }
};
