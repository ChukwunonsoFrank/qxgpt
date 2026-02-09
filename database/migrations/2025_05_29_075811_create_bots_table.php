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
        Schema::create('bots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->unsignedBigInteger('amount');
            $table->integer('duration');
            $table->integer('strategy');
            $table->string('account_type');
            $table->unsignedBigInteger('profit');
            $table->json('profit_values');
            $table->integer('profit_position');
            $table->string('asset');
            $table->string('asset_image_url');
            $table->string('sentiment');
            $table->string('status');
            $table->string('timer_checkpoint');
            $table->string('start');
            $table->string('end');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bots');
    }
};
