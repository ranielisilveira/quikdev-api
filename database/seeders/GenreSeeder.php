<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;
use GuzzleHttp\Client;
use Exception;
use Illuminate\Support\Facades\DB;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            DB::statement("set foreign_key_checks = 0");

            Genre::truncate();

            $key =  env('TMDB_APIKEY');
            $client = new Client([
                'base_uri' => 'https://api.themoviedb.org'
            ]);

            $response = $client->get('/3/genre/movie/list?api_key=' . $key . '&language=pt-BR');
            $genres = json_decode($response->getBody()->getContents(), true);

            foreach ($genres['genres'] as $genre) {
                Genre::create($genre);
            }
            DB::statement("set foreign_key_checks = 1");
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
