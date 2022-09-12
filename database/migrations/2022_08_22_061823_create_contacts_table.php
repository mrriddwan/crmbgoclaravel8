<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name', 100);
            $table->string('address')->nullable();
            $table->string('remark')->nullable();
            $table->unsignedBigInteger('user_id')->nullable()->constrained();
            $table->unsignedBigInteger('status_id')->nullable()->constrained();
            $table->unsignedBigInteger('type_id')->nullable()->constrained();
            $table->unsignedBigInteger('category_id')->nullable()->constrained();
            $table->unsignedBigInteger('industry_id')->nullable()->constrained();
            
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('status_id')
                ->references('id')
                ->on('contact_statuses')
                ->onDelete('cascade');

            $table->foreign('type_id')
                ->references('id')
                ->on('contact_types')
                ->onDelete('cascade');

            $table->foreign('industry_id')
                ->references('id')
                ->on('contact_industries')
                ->onDelete('cascade');

            $table->foreign('category_id')
                ->references('id')
                ->on('contact_categories')
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
        Schema::dropIfExists('contacts');
    }
};
