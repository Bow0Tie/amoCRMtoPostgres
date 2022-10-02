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
        Schema::create('teg_contacts', function (Blueprint $table) {
            $table->foreignId('contactId')->constrained('contacts');
            $table->foreignId('tegId')->constrained('tags');
            // $table->primary('contactId');
            $table->primary(['contactId', 'tegId']);
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
        Schema::dropIfExists('teg_contacts');
    }
};
