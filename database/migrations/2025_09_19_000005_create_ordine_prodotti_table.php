<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        if (!Schema::hasTable('ordine_prodotti')) {
            Schema::create('ordine_prodotti', function (Blueprint $table) {
                $table->integer('ordine_id');
                $table->integer('prodotto_id');
                $table->integer('quantita');
                $table->decimal('prezzo_unitario', 10, 2);
                $table->primary(['ordine_id', 'prodotto_id']);
            });
        }
    }
    public function down() {
        Schema::dropIfExists('ordine_prodotti');
    }
};
