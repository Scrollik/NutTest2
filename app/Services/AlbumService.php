<?php

namespace App\Services;

use App\Repositories\AlbumRepository;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;

class AlbumService
{
    protected AlbumRepository $albumRepository;
    protected ArtistService $artistService;

    public function __construct(AlbumRepository $albumRepository, ArtistService $artistService)
    {
        $this->albumRepository = $albumRepository;
        $this->artistService = $artistService;
    }

    public function getAlbums(Request $request): ?LengthAwarePaginator
    {
        return $this->albumRepository->getAlbums($request);
    }

    public function getArtists(): Collection
    {
        return $this->artistService->getArtistsForList();
    }


    public function findAlbumApi(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $response = Http::get(config('services.fm.url'), [
                'method' => 'album.search',
                'album' => $request->value,
                'api_key' => config('services.fm.key'),
                'limit' => '1',
                'format' => 'json',
            ]);
            $data = json_decode($response);
            foreach ($data->results->albummatches->album as $album) {
                foreach (end($album->image) as $item) {
                    return response()->json(['image' => $item]);
                }
            }
        }
    }

    public function storeAlbum(array $validated): void
    {
        $this->albumRepository->createAlbum($validated);
    }

    public function getAlbum(int $id): Model
    {
        return $this->albumRepository->getAlbum($id);
    }

    public function updateAlbum(array $validated): void
    {
        $this->albumRepository->updateAlbum($validated);
    }

    public function deleteAlbum(int $id): void
    {
        $this->albumRepository->deleteAlbum($id);
    }


}

