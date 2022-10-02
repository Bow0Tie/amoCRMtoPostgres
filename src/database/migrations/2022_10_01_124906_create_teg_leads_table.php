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
        Schema::create('teg_leads', function (Blueprint $table) {
            
            $table->foreignId('tegId')->constrained('tags');
            $table->foreignId('leadId')->constrained('leads_models');
            // $table->primary('leadId');
            $table->primary(['tegId', 'leadId']);
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
        Schema::dropIfExists('teg_leads');
    }
};
