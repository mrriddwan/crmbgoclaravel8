<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempboardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tempboards', function (Blueprint $table) {
            $table->id();
            $table->date('tpboard_entrydate');
            $table->unsignedBigInteger('contact_id')->nullable()->constrained();
            $table->foreign('contact_id')
                ->references('id')
                ->on('contacts')
                ->onDelete('cascade');
            $table->unsignedBigInteger('user_id')->nullable()->constrained();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->date('tpboard_startdate');
            $table->date('tpboard_enddate');
            $table->string('tpboard_size')->nullable();
            $table->string('tpboard_location')->nullable();
            $table->string('tpboard_unit')->nullable();
            $table->string('tpboard_collection')->nullable();
            $table->string('tpboard_material')->nullable();
            $table->string('tpboard_printing')->nullable();
            $table->string('tpboard_installation')->nullable();
            $table->string('tpboard_remark')->nullable();

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
        Schema::dropIfExists('tempboards');
    }
}
