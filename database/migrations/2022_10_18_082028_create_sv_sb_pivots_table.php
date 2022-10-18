<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSvSbPivotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sv_sb_pivots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supervisor_id')
                ->references('id')
                ->on('supervisors')
                ->nullable()
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('subordinate_id')
                ->references('id')
                ->on('users')
                ->nullable()
                ->constrained()
                ->onDelete('cascade');
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
        Schema::dropIfExists('sv_sb_pivots');
    }
}
