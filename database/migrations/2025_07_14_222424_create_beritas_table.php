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
    Schema::create('beritas', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->string('judul');
        $table->string('slug')->unique();
        $table->text('konten');
        $table->string('gambar')->nullable();
        $table->timestamp('published_at')->nullable();
        $table->timestamps(); // includes created_at & updated_at
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('beritas');
    }
};
