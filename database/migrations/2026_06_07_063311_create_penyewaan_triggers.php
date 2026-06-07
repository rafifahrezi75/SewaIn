<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop triggers if they already exist
        DB::unprepared('DROP TRIGGER IF EXISTS after_penyewaan_update');
        DB::unprepared('DROP TRIGGER IF EXISTS before_penyewaan_delete');

        // Trigger 1: after_penyewaan_update
        DB::unprepared('
            CREATE TRIGGER after_penyewaan_update
            AFTER UPDATE ON penyewaan
            FOR EACH ROW
            BEGIN
                -- 1. Status berubah dari selain \'disewa\' menjadi \'disewa\': Kurangi stok
                IF (OLD.status != \'disewa\' AND NEW.status = \'disewa\') THEN
                    UPDATE alat a
                    JOIN penyewaan_detail pd ON a.idalat = pd.idalat
                    SET a.stok = a.stok - pd.jumlah
                    WHERE pd.idsewa = NEW.idsewa;
                
                -- 2. Status berubah dari \'disewa\' menjadi selain \'disewa\' (seperti \'dibatalkan\' atau \'selesai\'): Kembalikan stok
                ELSEIF (OLD.status = \'disewa\' AND NEW.status != \'disewa\') THEN
                    UPDATE alat a
                    JOIN penyewaan_detail pd ON a.idalat = pd.idalat
                    SET a.stok = a.stok + pd.jumlah
                    WHERE pd.idsewa = NEW.idsewa;
                END IF;
            END
        ');

        // Trigger 2: before_penyewaan_delete
        DB::unprepared('
            CREATE TRIGGER before_penyewaan_delete
            BEFORE DELETE ON penyewaan
            FOR EACH ROW
            BEGIN
                -- Kembalikan stok saat data dihapus dengan status apapun
                UPDATE alat a
                JOIN penyewaan_detail pd ON a.idalat = pd.idalat
                SET a.stok = a.stok + pd.jumlah
                WHERE pd.idsewa = OLD.idsewa;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS after_penyewaan_update');
        DB::unprepared('DROP TRIGGER IF EXISTS before_penyewaan_delete');
    }
};
