<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        if (!Schema::hasTable('ordini')) {
            Schema::create('ordini', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('utente_id')->index();
                $table->timestamp('data_ordine')->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->decimal('totale', 10, 2);
                $table->enum('stato', ['in elaborazione', 'spedito', 'completato'])->default('in elaborazione')->nullable();
                $table->text('indirizzo_spedizione')->nullable();
            });
        }
    }
    public function down() {
        Schema::dropIfExists('ordini');
    }
};
