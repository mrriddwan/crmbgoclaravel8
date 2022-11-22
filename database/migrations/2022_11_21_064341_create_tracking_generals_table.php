<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrackingGeneralsTable extends Migration
{
    /**
     * Run the migrations.
     * 2022_11_21_064341_create_tracking_generals_table
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracking_generals', function (Blueprint $table) {
            $table->id();
            $table->string('progress')->nullable();
            $table->date('general_startdate')->nullable();
            $table->date('general_enddate')->nullable();

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
            
            $table->unsignedBigInteger('contact_category_id')->nullable()->constrained();
            $table->foreign('contact_category_id')
                ->references('id')
                ->on('contact_categories')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            
            $table->string('category_description')->nullable();

            $table->integer('art_frequency')->nullable();
            $table->string('general_type')->nullable();
            $table->integer('general_amount')->nullable();
            
            $table->integer('general_reach')->nullable();
            $table->integer('general_tenure')->nullable();
            $table->string('art_format')->nullable();
            $table->string('general_remark')->nullable();

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
        Schema::dropIfExists('tracking_generals');
    }
}
