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
            
            $table->date('wip_assignment_date')->nullable();
            $table->integer('wip_assignment_done')->nullable();
            $table->unsignedBigInteger('wip_assignment_user_id')->nullable()->constrained();
            $table->foreign('wip_assignment_user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');  
            $table->string('wip_assignment_remark')->nullable();
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
