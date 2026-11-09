<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        if (!Schema::hasTable('utenti')) {
            Schema::create('utenti', function (Blueprint $table) {
                $table->increments('id');
                $table->string('password', 255);
                $table->text('indirizzo')->nullable();
                $table->timestamp('data_registrazione')->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->string('username', 100)->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->timestamp('created_at')->nullable();
            });
        }
    }
    public function down() {
        Schema::dropIfExists('utenti');
    }
};
