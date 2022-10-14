<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('password');
            $table->string('email')->unique();
            $table->string('email_password');
            $table->timestamp('email_verified_at')->nullable();

            $table->unsignedBigInteger('user_cat_id')->nullable()->constrained();
            $table->foreign('user_cat_id')
                ->references('id')
                ->on('user_categories')
                ->nullOnDelete('');

            $table->unsignedBigInteger('user_auth_id')->nullable()->constrained();
            $table->foreign('user_auth_id')
                ->references('id')
                ->on('user_auths')
                ->nullOnDelete('');

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
