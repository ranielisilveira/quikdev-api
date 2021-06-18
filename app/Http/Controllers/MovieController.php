<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Movie;
use GuzzleHttp\Client;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MovieController extends Controller
{
    public function show($id)
    {
        try {
            $key =  env('TMDB_APIKEY');
            $client = new Client([
                'base_uri' => 'https://api.themoviedb.org'
            ]);

            $response = $client->get('/3/movie/' . $id . '?api_key=' . $key . '&language=pt-BR');
            $movie = json_decode($response->getBody()->getContents(), true);

            $movie['backdrop_path'] = env('TMDB_IMAGES') . 'original' . $movie['backdrop_path'];
            $movie['poster_path'] = env('TMDB_IMAGES') . 'original' . $movie['poster_path'];

            return response($movie);
        } catch (Exception $e) {
            return response([
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function trending()
    {
        try {
            return Movie::orderByDesc('popularity')->orderBy('name')->limit(20)->get();
        } catch (Exception $e) {
            return response([
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function genres()
    {
        try {
            return Genre::all();
        } catch (Exception $e) {
            return response([
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function search(Request $request)
    {
        try {
            $movies = Movie::whereHas('genres', function ($genres) use ($request) {
                if ($request->genre) {
                    $genres->where('id', $request->genre);
                }
            });

            if ($request->search && !empty($request->search)) {
                $movies->where('name', 'LIKE', "%$request->search%");
            }

            return $movies->orderBy('name')->paginate(20);
        } catch (Exception $e) {
            return response([
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
