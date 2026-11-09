<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('ordine_prodotti', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ordine_id');
            $table->unsignedBigInteger('prodotto_id');
            $table->integer('quantita');
            $table->decimal('prezzo', 10, 2);
            $table->foreign('ordine_id')->references('id')->on('ordini')->onDelete('cascade');
            $table->foreign('prodotto_id')->references('id')->on('prodotti')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ordine_prodotti');
    }
};
