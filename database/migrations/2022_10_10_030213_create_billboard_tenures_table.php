<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillboardTenuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billboard_tenures', function (Blueprint $table) {
            $table->id();
            $table->date('tenure_startdate');
            $table->date('tenure_enddate');
            $table->unsignedBigInteger('bboard_id')->nullable()->constrained();
            $table->foreign('bboard_id')
                ->references('id')
                ->on('billboards')
                ->onDelete('cascade');
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
        Schema::dropIfExists('billboard_tenures');
    }
}
