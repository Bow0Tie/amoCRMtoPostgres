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
        Schema::create('leads_models', function (Blueprint $table) {
            $table->integer('id')->primary('id')->unique('id');

            $table->string('name');
            $table->integer('responsibleUserId');
            $table->integer('groupId');
            $table->integer('createdBy');
            $table->integer('updatedBy');
            $table->integer('createdAt');
            $table->integer('updatedAt');
            $table->integer('accountId');
            $table->integer('pipelineId');
            $table->integer('statusId');
            $table->integer('closedAt');
            $table->integer('closestTaskAt');
            $table->integer('price');
            $table->boolean('isDeleted');
            $table->integer('sourceId');
            $table->integer('sourceExternalId');
            $table->integer('score');
            $table->boolean('isPriceModifiedByRobot');
            $table->integer('visitorUid');
            $table->boolean('isMerged');
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
        Schema::dropIfExists('leads_models');
    }
};
