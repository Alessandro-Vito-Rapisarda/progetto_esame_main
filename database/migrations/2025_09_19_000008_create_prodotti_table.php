<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        if (!Schema::hasTable('prodotti')) {
            Schema::create('prodotti', function (Blueprint $table) {
                $table->increments('id');
                $table->string('nome', 200);
                $table->text('descrizione')->nullable();
                $table->decimal('prezzo', 10, 2);
                $table->integer('quantita_disponibile')->nullable()->default(0);
                $table->integer('categoria_id')->nullable()->index();
                $table->string('immagine_url', 255)->nullable();
            });
        }
    }
    public function down() {
        Schema::dropIfExists('prodotti');
    }
};
