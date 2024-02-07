<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('artist_bank', function (Blueprint $table) {
            $table->foreignId('artist_id');
            $table->string('CID')->unique();
            $table->string('ownerFName');
            $table->string('ownerLName');
            $table->string('accountNum');
            $table->string('BankCardNum');
            $table->string('ShabaNum')->unique();
            $table->tinyInteger('status')->default(0);
            $table->timestamps();

            $table->foreign('artist_id')->references('id')->on('users')
            ->constrained()
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->primary(['artist_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artist_bank');
    }
};
