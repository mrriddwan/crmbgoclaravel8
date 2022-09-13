<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForecastsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forecasts', function (Blueprint $table) {
            $table->id();
            $table->date('forecast_updatedate');
            $table->integer('amount');
            $table->date('forecast_date');
            // $table->date('forecast_result_id');
            $table->unsignedBigInteger('forecast_result_id')->nullable()->constrained();
            $table->foreign('forecast_result_id')
                ->references('id')
                ->on('forecast_result')
                ->onDelete('cascade');
            $table->unsignedBigInteger('user_id')->nullable()->constrained();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->unsignedBigInteger('contact_id')->nullable()->constrained();
            $table->foreign('contact_id')
                ->references('id')
                ->on('contacts')
                ->onDelete('cascade');
            $table->unsignedBigInteger('product_id')->nullable()->constrained();
            $table->foreign('product_id')
                ->references('id')
                ->on('forecast_products')
                ->onDelete('cascade');
            $table->unsignedBigInteger('type_id')->nullable()->constrained();
            $table->foreign('type_id')
                ->references('id')
                ->on('contact_types')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forecasts');
    }
}
