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
        Schema::table('boats', function (Blueprint $table) {
            $table->string('type_fr')->after('description_en')->nullable();
            $table->string('type_en')->after('type_fr')->nullable();
            $table->integer('displacements')->after('type_en')->nullable();
            $table->integer('surface')->after('displacements')->nullable();
            $table->integer('engine_power')->after('surface')->nullable();
            $table->string('hull_fr')->after('engine_power')->nullable();
            $table->string('hull_en')->after('hull_fr')->nullable();
            $table->string('deck_fr')->after('hull_en')->nullable();
            $table->string('deck_en')->after('deck_fr')->nullable();
            $table->string('mast_fr')->after('deck_en')->nullable();
            $table->string('mast_en')->after('mast_fr')->nullable();
            $table->string('architect')->after('mast_en')->nullable();
            $table->text('diverse_fr')->after('architect')->nullable();
            $table->text('diverse_en')->after('diverse_fr')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('boats', function (Blueprint $table) {
            $table->dropColumn(['type_fr', 'type_en', 'displacements', 'surface', 'engine_power', 'hull_fr', 'hull_en', 'deck_fr', 'deck_en', 'mast_fr', 'mast_en', 'architect', 'diverse_fr', 'diverse_en']);
        });
    }
};
