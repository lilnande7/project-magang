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
        // 1. Tambah kolom bibliografi ke tabel books (dari SLiMS)
        Schema::table('books', function (Blueprint $table) {
            $table->string('gmd_name')->nullable()->after('title');       // General Material Designation
            $table->string('call_number')->nullable()->after('isbn');      // Nomor panggil
            $table->string('place_name')->nullable()->after('publisher');  // Kota terbit
            $table->string('classification')->nullable()->after('call_number'); // Klasifikasi DDC
            $table->string('series_title')->nullable()->after('classification');
            $table->string('collation')->nullable()->after('series_title'); // Deskripsi fisik (halaman)
            $table->string('cover_url')->nullable()->after('cover_image'); // URL cover dari SLiMS
            $table->string('item_code')->nullable()->after('cover_url');   // Kode eksemplar SLiMS
            $table->string('topics')->nullable()->after('subjects');       // Topik/kata kunci
        });

        // 2. Ubah enum status borrowings: tambah 'pending' dan 'rejected'
        //    MySQL tidak bisa modify enum langsung — pakai DB::statement
        if (\DB::getDriverName() !== 'sqlite') {
            \DB::statement("ALTER TABLE borrowings MODIFY COLUMN status ENUM('pending','active','returned','overdue','rejected') NOT NULL DEFAULT 'pending'");
        }

        // 3. Tambah kolom tambahan untuk alur approval
        Schema::table('borrowings', function (Blueprint $table) {
            $table->unsignedBigInteger('approved_by')->nullable()->after('notes');
            $table->timestamp('approved_at')->nullable()->after('approved_by');
            $table->text('rejection_reason')->nullable()->after('approved_at');
            $table->date('requested_at')->nullable()->after('user_id');

            $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('borrowings', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropColumn(['approved_by', 'approved_at', 'rejection_reason', 'requested_at']);
        });

        if (\DB::getDriverName() !== 'sqlite') {
            \DB::statement("ALTER TABLE borrowings MODIFY COLUMN status ENUM('active','returned','overdue') NOT NULL DEFAULT 'active'");
        }

        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn([
                'gmd_name', 'call_number', 'place_name', 'classification',
                'series_title', 'collation', 'cover_url', 'item_code', 'topics'
            ]);
        });
    }
};
