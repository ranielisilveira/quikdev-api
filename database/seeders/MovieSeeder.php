<?php

namespace Database\Seeders;

use App\Models\Movie;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use GuzzleHttp\Client;
use Exception;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Output\ConsoleOutput;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $output = new ConsoleOutput();
        $output->writeln("<info>Start Populate Movies</info>");

        try {
            DB::statement("set foreign_key_checks = 0");
            Movie::truncate();
            DB::statement("set foreign_key_checks = 1");

            $key =  env('TMDB_APIKEY');
            $client = new Client([
                'base_uri' => 'https://api.themoviedb.org'
            ]);

            $response = $client->get('/3/discover/movie?api_key=' . $key . '&language=pt-BR');
            $movies = json_decode($response->getBody()->getContents(), true);

            $total_pages =  $movies['total_pages'];

            for ($page = 1; $page < $total_pages; $page++) {
                $response = $client->get('/3/discover/movie?api_key=' . $key . '&language=pt-BR&page=' . $page);
                $movies = json_decode($response->getBody()->getContents(), true);

                $results = $movies['results'];

                foreach ($results as $movie) {
                    $output->writeln("<info>" . $movie['title'] . " - saved!</info>");

                    $dbMovie = Movie::create([
                        'poster' => $movie['poster_path'],
                        'name' => $movie['title'],
                        'overview' => $movie['overview'],
                        'popularity' => $movie['popularity'] ?? null,
                        'release_date' => isset($movie['release_date']) ? (Carbon::parse($movie['release_date']) ??  null) : null,
                    ]);

                    $dbMovie->genres()->sync($movie['genre_ids']);
                }
            }
            $output->writeln("<info>End Populate Movies</info>");
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
