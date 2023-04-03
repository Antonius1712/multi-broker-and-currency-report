<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogSendingCollectionInternal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_sending_collection_internal', function (Blueprint $table) {
            $table->id();
            $table->string('email')->nullable();
            $table->string('email_sent')->nullable();
            $table->string('email_subject')->nullable();
            $table->text('email_body')->nullable();
            $table->string('year')->nullable();
            $table->string('month')->nullable();
            $table->string('date')->nullable();
            $table->string('day')->nullable();
            $table->string('time')->nullable();
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
        Schema::dropIfExists('log_sending_collection_internal');
    }
}
