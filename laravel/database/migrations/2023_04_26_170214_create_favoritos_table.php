<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('favoritos', function (Blueprint $table) {
        $table->unsignedBigInteger('user_id');
        $table->unsignedBigInteger('id_peliserie');
        $table->Enum('tipo', ['pelicula', 'serie']);

        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });

    Schema::table('favoritos', function (Blueprint $table) {
        $table->id()->first();
        $table->unique(['user_id', 'id_peliserie']);
    });
    
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('favoritos');
    }
};