<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWipTravelGuidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wip_travel_guides', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tracking_tguide_id')->nullable()->constrained();
            $table->foreign('tracking_tguide_id')
                ->references('id')
                ->on('tracking_travel_guides')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('wip_package_name')->nullable();
            $table->date('wip_package_date')->nullable();
            $table->integer('wip_package_done')->nullable();
            $table->unsignedBigInteger('wip_package_user_id')->nullable()->constrained();
            $table->foreign('wip_package_user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');  
            $table->string('wip_package_remark')->nullable();
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
        Schema::dropIfExists('wip_travel_guides');
    }
}
