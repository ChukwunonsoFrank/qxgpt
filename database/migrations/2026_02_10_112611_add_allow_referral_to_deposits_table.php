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
    Schema::table('deposits', function (Blueprint $table) {
      $table->boolean('allow_referral')->after('payment_screenshot_path')->default(true);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('deposits', function (Blueprint $table) {
      $table->dropColumn('allow_referral');
    });
  }
};
