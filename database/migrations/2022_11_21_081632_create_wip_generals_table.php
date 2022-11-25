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
            $table->string('wip_remark')->nullable();
            $table->string('wip_progress')->nullable();
            $table->unsignedBigInteger('tracking_general_id')->nullable()->constrained();
            $table->foreign('tracking_general_id')
                ->references('id')
                ->on('tracking_generals')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->integer('frequency_no')->nullable();

            $table->date('art_chase_date')->nullable();
            $table->integer('art_chase_done')->nullable();
            $table->string('art_chase_remark')->nullable();
            $table->unsignedBigInteger('art_chase_user_id')->nullable()->constrained();
            $table->foreign('art_chase_user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->date('art_received_date')->nullable();
            $table->string('art_received_remark')->nullable();
            $table->integer('art_received_done')->nullable();
            $table->unsignedBigInteger('art_received_user_id')->nullable()->constrained();
            $table->foreign('art_received_user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->date('art_todo_date')->nullable();
            $table->string('art_todo_remark')->nullable();
            $table->integer('art_todo_done')->nullable();
            $table->unsignedBigInteger('art_todo_user_id')->nullable()->constrained();
            $table->foreign('art_todo_user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            
            $table->date('cns_sent_date')->nullable();
            $table->string('cns_sent_remark')->nullable();
            $table->integer('cns_sent_done')->nullable();
            $table->unsignedBigInteger('cns_sent_user_id')->nullable()->constrained();
            $table->foreign('cns_sent_user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->date('cns_record_date')->nullable();
            $table->string('cns_record_remark')->nullable();
            $table->integer('cns_record_done')->nullable();
            $table->unsignedBigInteger('cns_record_user_id')->nullable()->constrained();
            $table->foreign('cns_record_user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->date('schedule_date')->nullable();
            $table->string('schedule_remark')->nullable();
            $table->integer('schedule_done')->nullable();
            $table->unsignedBigInteger('schedule_user_id')->nullable()->constrained();
            $table->foreign('schedule_user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->date('actual_live_date')->nullable();
            $table->string('actual_live_remark')->nullable();
            $table->integer('actual_live_done')->nullable();
            $table->unsignedBigInteger('actual_live_user_id')->nullable()->constrained();
            $table->foreign('actual_live_user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->date('client_posting_date')->nullable();
            $table->string('client_posting_remark')->nullable();
            $table->integer('client_posting_done')->nullable();
            $table->unsignedBigInteger('client_posting_user_id')->nullable()->constrained();
            $table->foreign('client_posting_user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->date('report_date')->nullable();
            $table->string('report_remark')->nullable();
            $table->integer('report_done')->nullable();
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
