<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        if (!Schema::hasTable('categorie')) {
            Schema::create('categorie', function (Blueprint $table) {
                $table->increments('id');
                $table->string('nome', 100);
                $table->text('descrizione')->nullable();
            });
        }
    }
    public function down() {
        Schema::dropIfExists('categorie');
    }
};
