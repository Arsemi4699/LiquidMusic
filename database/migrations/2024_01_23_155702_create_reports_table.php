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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('music_id');
            $table->enum('type', ['Copyright', 'ChildAbuse', 'Violence', 'Unethical', 'Other'])->default('Other');
            $table->enum('level', ['low', 'medium', 'high'])->default('low');
            $table->string('info')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->timestamp('created_at');

            $table->foreign('music_id')->references('id')->on('songs')
            ->constrained()
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
