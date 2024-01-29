<?php

namespace App\Services;

use App\Repositories\ArtistRepository;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;


class ArtistService
{
    protected ArtistRepository $artistRepository;

    public function __construct(ArtistRepository $ArtistRepository)
    {
        $this->artistRepository = $ArtistRepository;
    }

    public function getArtists(array $validated): ?LengthAwarePaginator
    {
        return $this->artistRepository->getArtists($validated);
    }

    public function getArtistsForList()
    {
        return $this->artistRepository->getArtistsForList();
    }

    public function findArtistApi(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $response = Http::get(config('services.fm.url'), [
                'method' => 'artist.search',
                'artist' => $request->value,
                'api_key' => config('services.fm.key'),
                'limit' => '1',
                'format' => 'json',
            ]);
            $data = json_decode($response);
            foreach ($data->results->artistmatches->artist as $artist) {
                foreach (end($artist->image) as $item) {
                    return response()->json(['image' => $item]);
                }
            }
        }
    }

    public function storeArtist(array $validated): void
    {

        $this->artistRepository->createArtist($validated);
    }

    public function getArtist(int $id): Model
    {
        return $this->artistRepository->getArtist($id);
    }

    public function updateArtist(array $validated)
    {
        $this->artistRepository->updateArtist($validated);
    }

    public function deleteArtist(int $id): void
    {
        $this->artistRepository->deleteArtist($id);
    }


}

