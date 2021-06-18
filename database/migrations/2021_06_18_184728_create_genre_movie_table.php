<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGenreMovieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('genre_movie', function (Blueprint $table) {
            $table->bigInteger('genre_id')->unsigned();
            $table->bigInteger('movie_id')->unsigned();
        });

        Schema::table('genre_movie', function (Blueprint $table) {
            $table->foreign('genre_id', 'foreign_genre_id')->references('id')->on('genres');
            $table->foreign('movie_id', 'foreign_movie_id')->references('id')->on('movies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('genre_movie', function (Blueprint $table) {
            $table->dropForeign('foreign_genre_id');
            $table->dropForeign('foreign_movie_id');
        });
        Schema::dropIfExists('genre_movie');
    }
}
