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
        Schema::create('contact_leads', function (Blueprint $table) {
            $table->foreignId('contactId')->constrained('contacts');
            $table->foreignId('leadId')->constrained('leads_models');
            // $table->primary('leadId');
            $table->primary(['contactId', 'leadId']);
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
        Schema::dropIfExists('contact_leads');
    }
};
