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
        Schema::create('song_in_playlist', function (Blueprint $table) {
            $table->foreignId('list_id');
            $table->foreignId('music_id');
            $table->timestamp('updated_at');

            $table->foreign('list_id')->references('id')->on('playlists')
            ->constrained()
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->foreign('music_id')->references('id')->on('songs')
            ->constrained()
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->primary(['list_id', 'music_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('song_in_playlist');
    }
};
