<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        if (!Schema::hasTable('preferiti')) {
            Schema::create('preferiti', function (Blueprint $table) {
                $table->integer('utente_id');
                $table->integer('prodotto_id');
                $table->primary(['utente_id', 'prodotto_id']);
            });
        }
    }
    public function down() {
        Schema::dropIfExists('preferiti');
    }
};
