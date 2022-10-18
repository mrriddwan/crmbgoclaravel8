<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCategoryBenchmarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_category_benchmarks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_cat_id')->nullable()->constrained();
            $table->foreign('user_cat_id')
                ->references('id')
                ->on('user_categories')
                ->onDelete('cascade');

            $table->unsignedBigInteger('action_id')->nullable()->constrained();
            $table->foreign('action_id')
                ->references('id')
                ->on('actions')
                ->onDelete('cascade');

            $table->integer('action_target');

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
        Schema::dropIfExists('user_category_benchmarks');
    }
}
