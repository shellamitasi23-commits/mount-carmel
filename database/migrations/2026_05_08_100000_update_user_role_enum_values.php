<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    DB::statement("ALTER TABLE `users` MODIFY `role` ENUM('pembeli','marketing','manajer','accounting','koordinator_lapangan') NOT NULL DEFAULT 'pembeli'");
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    DB::statement("ALTER TABLE `users` MODIFY `role` ENUM('pembeli','marketing','manajer','accounting','koordinator_lapangan') NOT NULL DEFAULT 'pembeli'");
  }
};
