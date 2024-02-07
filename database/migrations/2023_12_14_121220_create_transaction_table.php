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
        Schema::create('transaction', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('plan_item_id')->nullable();
            $table->foreignId('beatsPack_item_id')->nullable();
            $table->string('token')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->unsignedInteger('price_T')->default(0);
            $table->timestamps();

            $table->foreign('plan_item_id')->references('id')->on('sub_plans')
            ->constrained()
            ->onUpdate('cascade')
            ->onDelete('set null');

            $table->foreign('beatsPack_item_id')->references('id')->on('beats_pack')
            ->constrained()
            ->onUpdate('cascade')
            ->onDelete('set null');

            $table->foreign('user_id')->references('id')->on('users')
            ->constrained()
            ->onUpdate('cascade')
            ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction');
    }
};
