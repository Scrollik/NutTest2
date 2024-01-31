<?php

namespace App\Services;

use App\Repositories\ArtistRepository;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


class ArtistService
{
    protected ArtistRepository $artistRepository;

    public function __construct(ArtistRepository $ArtistRepository)
    {
        $this->artistRepository = $ArtistRepository;
    }

    public function getArtists(array $validated): ?LengthAwarePaginator
    {
        if (!empty($validated)) {
            return $this->artistRepository->filterByName($validated['artist_name']);
        } else {
            return $this->artistRepository->getArtists();
        }
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
        if (!empty($validated['yourImage'])) {
            $image = $validated['yourImage'];
            $imageName = $validated['yourImage']->getClientOriginalName();
            $image->move('artist_image', $imageName);
        } else {
            $contents = file_get_contents($validated['image']);
            $imageName = substr($validated['image'], strrpos($validated['image'], '/') + 1);
            Storage::disk('artist_image')->put($imageName, $contents);
        }
        $result = $this->artistRepository->createArtist($validated, $imageName);
        if ($result) {
            Log::channel('artist_creates')->info(
                'Пользователь {user} создал исполнителя {name}',
                [
                    'name' => $validated['name'],
                    'user' => Auth::user()->email,
                ]
            );
        }
    }

    public function getArtist(int $id): Model
    {
        return $this->artistRepository->getArtist($id);
    }

    public function updateArtist(array $validated): void
    {
        if (!empty($validated['new_image'])) {
            Storage::delete('artist_image/' . $validated['image']);
            $image = $validated['new_image'];
            $imageName = $validated['new_image']->getClientOriginalName();
            $image->move('Artist_image', $imageName);
        } else {
            $contents = file_get_contents($validated['image']);
            $imageName = substr($validated['image'], strrpos($validated['image'], '/') + 1);
            Storage::delete('artist_image/' . $validated['image']);
            Storage::disk('artist_image')->put($imageName, $contents);
        }
        $result = $this->artistRepository->updateArtist($validated, $imageName);
        if ($result) {
            Log::channel('artist_updates')
                ->info(
                    'Был изменен исполнитель: {name}, пользователем: {user}.',
                    [
                        'name' => $validated['name'],
                        'user' => Auth::user()->email,
                    ]
                );
        }
    }

    public function deleteArtist(int $id): void
    {
       $artist = $this->artistRepository->deleteArtist($id);
       if (!empty($artist))
       {
           Storage::delete('artist_image/' . $artist->image);
           Log::channel('artist_deletes')
               ->info(
                   'Информация об альбоме {name} удалена.',
                   ['name' => $artist->name]
               );
       }
    }


}

