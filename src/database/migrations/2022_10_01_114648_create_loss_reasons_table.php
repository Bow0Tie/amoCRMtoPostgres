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
        Schema::create('loss_reasons', function (Blueprint $table) {
            $table->integer('id')->primary('id')->unique('id');

            $table->string('name');
            $table->integer('sort');
            $table->integer('createdAt');
            $table->integer('updatedAt');
            $table->integer('requestId');

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
        Schema::dropIfExists('loss_reasons');
    }
};
