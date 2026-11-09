<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        if (!Schema::hasTable('immagini_prodotti')) {
            Schema::create('immagini_prodotti', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('prodotto_id');
                $table->string('url', 255);
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
            });
        }
    }
    public function down() {
        Schema::dropIfExists('immagini_prodotti');
    }
};
