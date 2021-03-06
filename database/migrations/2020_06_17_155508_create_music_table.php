<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMusicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('music', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->uuid('genre_id');
            $table->uuid('key_id')->nullable();
            $table->string('title');
            $table->string('type');
            $table->longText('description');
            $table->string('tempo_of_beat')->nullable();
            $table->string('cover_art')->nullable();
            $table->string('music');
            $table->integer('is_paid')->default(0);
            $table->integer('status')->default(0);
            $table->double('price')->default(0);
            $table->integer('views')->default(0);
            $table->integer('downloads')->default(0);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('genre_id')->references('id')->on('genres')->onDelete('cascade');
            $table->foreign('key_id')->references('id')->on('keys')->onDelete('cascade');
            $table->string('duration')->nullable();
            $table->string('size')->nullable();
            $table->longText('lyrics')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('music');
    }
}
