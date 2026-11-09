<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        if (!Schema::hasTable('carrello')) {
            Schema::create('carrello', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('utente_id')->index();
                $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->enum('stato', ['attivo', 'convertito', 'abbandonato'])->default('attivo')->nullable();
                $table->timestamp('updated_at')->nullable();
            });
        }
    }
    public function down() {
        Schema::dropIfExists('carrello');
    }
};
