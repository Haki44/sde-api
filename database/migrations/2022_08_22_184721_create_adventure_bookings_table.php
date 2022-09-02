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
        Schema::create('adventure_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('firstname');
            $table->string('nationality');
            $table->string('email');
            $table->string('tel');
            $table->string('places_needed');
            $table->text('description')->nullable();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->foreignId('adventure_id')->nullable()->constrained();
            $table->boolean('is_validate')->default(0);
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
        Schema::dropIfExists('adventure_bookings');
    }
};
