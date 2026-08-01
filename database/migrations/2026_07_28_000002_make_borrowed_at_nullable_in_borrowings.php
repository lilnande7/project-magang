<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('borrowings', function (Blueprint $table) {
            // borrowed_at dan due_date harus nullable karena belum terisi saat status pending
            $table->date('borrowed_at')->nullable()->change();
            $table->date('due_date')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('borrowings', function (Blueprint $table) {
            $table->date('borrowed_at')->nullable(false)->change();
            $table->date('due_date')->nullable(false)->change();
        });
    }
};
