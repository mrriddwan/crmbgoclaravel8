<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWipGeneralsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wip_generals', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('tracking_general_id')->nullable()->constrained();
            $table->foreign('tracking_general_id')
                ->references('id')
                ->on('tracking_generals')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->integer('frequency_no')->nullable();

            $table->date('art_chase_date')->nullable();
            $table->string('art_chase_remark')->nullable();
            $table->unsignedBigInteger('art_chase_user_id')->nullable()->constrained();
            $table->foreign('art_chase_user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->date('art_received_date')->nullable();
            $table->string('art_received_remark')->nullable();
            $table->unsignedBigInteger('art_received_user_id')->nullable()->constrained();
            $table->foreign('art_received_user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->date('art_todo_date')->nullable();
            $table->string('art_todo_remark')->nullable();
            $table->unsignedBigInteger('art_todo_user_id')->nullable()->constrained();
            $table->foreign('art_todo_user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            
            $table->date('c&s_sent_date')->nullable();
            $table->string('c&s_sent_remark')->nullable();
            $table->unsignedBigInteger('c&s_sent_user_id')->nullable()->constrained();
            $table->foreign('c&s_sent_user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->date('c&s_record_date')->nullable();
            $table->string('c&s_record_remark')->nullable();
            $table->unsignedBigInteger('c&s_record_user_id')->nullable()->constrained();
            $table->foreign('c&s_record_user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->date('schedule_date')->nullable();
            $table->string('schedule_remark')->nullable();
            $table->unsignedBigInteger('schedule_user_id')->nullable()->constrained();
            $table->foreign('schedule_user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->date('live_date')->nullable();
            $table->string('live_remark')->nullable();
            $table->unsignedBigInteger('live_user_id')->nullable()->constrained();
            $table->foreign('live_user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->date('client_posting_date')->nullable();
            $table->string('client_posting_remark')->nullable();
            $table->unsignedBigInteger('client_posting_user_id')->nullable()->constrained();
            $table->foreign('client_posting_user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->date('report_date')->nullable();
            $table->string('report_remark')->nullable();
            $table->unsignedBigInteger('report_user_id')->nullable()->constrained();
            $table->foreign('report_user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
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
        Schema::dropIfExists('wip_generals');
    }
}
