<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrackingTravelGuidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracking_travel_guides', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->constrained();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('company_id')->nullable()->constrained();
            $table->foreign('company_id')
                ->references('id')
                ->on('contacts')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->date('art_reminder_date')->nullable();
            $table->string('art_reminder_remark')->nullable();
            $table->integer('art_reminder_done')->nullable();
            $table->unsignedBigInteger('art_reminder_user_id')->nullable()->constrained();
            $table->foreign('art_reminder_user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            
            $table->date('art_record_date')->nullable();
            $table->string('art_record_remark')->nullable();
            $table->integer('art_record_done')->nullable();
            $table->unsignedBigInteger('art_record_user_id')->nullable()->constrained();
            $table->foreign('art_record_user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            
            $table->string('edition')->nullable();
            $table->string('tguide_size')->nullable();
            $table->string('tguide_remark')->nullable();

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
        Schema::dropIfExists('tracking_travel_guides');
    }
}
