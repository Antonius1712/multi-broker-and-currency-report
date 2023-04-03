<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollectionEmail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collection_email', function (Blueprint $table) {
            $table->id();
            $table->string('id_profile')->nullable();
            $table->string('broker_name')->nullable();
            $table->string('pic_on_system')->nullable();
            $table->string('pic_email_on_system')->nullable();
            $table->string('pic_emailed_by_finance')->nullable();
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
        Schema::dropIfExists('collection_email');
    }
}
