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
            $table->integer('id')->primary('id')->unique('id');

            $table->string('firstName');
            $table->string('lastName');
            $table->integer('responsibleUserId');
            $table->integer('groupId');
            $table->integer('createdBy');
            $table->integer('updatedBy');
            $table->integer('createdAt');
            $table->integer('updatedAt');
            $table->integer('closestTaskAt');
            $table->integer('accountId');
            $table->string('PHONE');
            $table->string('EMAIL');
            $table->string('POSITION');
            $table->boolean('isMain')->nullable();
            $table->integer('requestId');

            $table->foreignId('companyId')->constrained('companies');

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
        Schema::dropIfExists('contacts');
    }
};
