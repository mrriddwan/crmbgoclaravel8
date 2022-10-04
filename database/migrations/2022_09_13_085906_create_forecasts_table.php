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
            $table->unsignedBigInteger('result_id')->nullable()->constrained();
            $table->foreign('result_id')
                ->references('id')
                ->on('forecast_results')
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
            $table->unsignedBigInteger('forecast_type_id')->nullable()->constrained();
            $table->foreign('forecast_type_id')
                ->references('id')
                ->on('forecast_types')
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
        Schema::dropIfExists('forecasts');
    }
}
