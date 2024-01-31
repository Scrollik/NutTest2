<?php

namespace App\Services;

use App\Repositories\AlbumRepository;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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
        if (!empty($request->artist)) {
            return $this->albumRepository->findByArtist($request->artist);
        } else {
            return $this->albumRepository->getAlbums();
        }
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
        if (!empty($validated['yourImage'])) {
            $image = $validated['yourImage'];
            $imageName = $validated['yourImage']->getClientOriginalName();
            $image->move('album_image', $imageName);
        } else {
            $contents = file_get_contents($validated['image']);
            $imageName = substr($validated['image'], strrpos($validated['image'], '/') + 1);
            Storage::disk('album_image')->put($imageName, $contents);
        }
        $result = $this->albumRepository->createAlbum($validated, $imageName);
        if ($result) {
            Log::channel('album_creates')->info(
                'Пользователь: {user} создал альбом {name}',
                [
                    'name' => $validated['name'],
                    'user' => Auth::user()->email,
                ]
            );
        }
    }

    public function getAlbum(int $id): Model
    {
        return $this->albumRepository->getAlbum($id);
    }

    public function updateAlbum(array $validated): void
    {
        if (!empty($validated['new_image'])) {
            Storage::delete('album_image/' . $validated['image']);
            $image = $validated['new_image'];
            $imageName = $validated['new_image']->getClientOriginalName();
            $image->move('album_image', $imageName);
        } else {
            $imageName = $validated['image'];
        }
        $result = $this->albumRepository->updateAlbum($validated, $imageName);
        if ($result) {
            Log::channel('album_updates')
                ->info(
                    'Был изменен альбом: {name}, пользователем: {user}.',
                    [
                        'name' => $validated['name'],
                        'user' => Auth::user()->email,
                    ]
                );
        }
    }

    public function deleteAlbum(int $id): void
    {
        $album = $this->albumRepository->deleteAlbum($id);
        if (!empty($album)) {
            Storage::delete('album_image/' . $album->image);
            Log::channel('album_deletes')
                ->info(
                    'Информация об альбоме {name} удалена.',
                    ['name' => $album->name]
                );
        }
    }


}

