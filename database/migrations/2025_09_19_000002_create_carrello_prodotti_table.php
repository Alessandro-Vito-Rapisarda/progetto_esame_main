<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        if (!Schema::hasTable('carrello_prodotti')) {
            Schema::create('carrello_prodotti', function (Blueprint $table) {
                $table->integer('carrello_id');
                $table->integer('prodotto_id');
                $table->integer('quantita')->default(1);
                $table->string('nome', 100)->nullable();
                $table->double('prezzo')->nullable();
                $table->string('descrizione', 100)->nullable();
                $table->string('immagine_url', 255)->nullable();
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->primary(['carrello_id', 'prodotto_id']);
            });
        }
    }
    public function down() {
        Schema::dropIfExists('carrello_prodotti');
    }
};
