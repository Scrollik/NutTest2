<?php

namespace App\Repositories;

use App\Interfaces\AlbumRepositoryInterface;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Ramsey\Collection\Collection;

class AlbumRepository implements AlbumRepositoryInterface
{
    protected Album $albumInfo;

    public function __construct(Album $albumInfo)
    {
        $this->album = $albumInfo;
    }

    public function getAlbums(Request $request): ?LengthAwarePaginator
    {
        if (!empty($request->artist)) {
            return $this->findByArtist($request->artist);
        } else {
            return Album::with('artist')
                ->paginate(5);
        }
    }

    public function findByArtist(int $id): LengthAwarePaginator
    {
        return Album::where('artist_id', $id)
            ->with('artist')
            ->paginate(5);
    }

    public function createAlbum(array $validated): void
    {
        if (!empty($validated['yourImage'])) {
            $image = $validated['yourImage'];
            $imageName = $validated['yourImage']->getClientOriginalName();
            $image->move('album_image', $imageName);
            Album::create([
                'name' => $validated['name'],
                'artist_id' => $validated['artist'],
                'description' => $validated['descr'],
                'image' => $imageName,
            ]);
        } else {
            $contents = file_get_contents($validated['image']);
            $imageName = substr($validated['image'], strrpos($validated['image'], '/') + 1);
            Storage::disk('album_image')->put($imageName, $contents);
            Album::create([
                'name' => $validated['name'],
                'artist_id' => $validated['artist'],
                'description' => $validated['descr'],
                'image' => $imageName,
            ]);
        }
        Log::channel('album_creates')->info(
            'Пользователь {user} создал альбом {name}',
            [
                'name' => $validated['name'],
                'user' => Auth::user()->email,
            ]
        );
    }

    public function getAlbum(int $id): Model
    {
        return Album::where('id', $id)
            ->with('artist')
            ->first();
    }

    public function updateAlbum(array $validated): void
    {
        if (!empty($validated['new_image'])) {
            Storage::delete('album_image/' . $validated['image']);
            $image = $validated['new_image'];
            $imageName = $validated['new_image']->getClientOriginalName();
            $image->move('album_image', $imageName);
            Album::where('id', $validated['id'])
                ->update([
                    'name' => $validated['name'],
                    'artist_id' => $validated['artist'],
                    'description' => $validated['descr'],
                    'image' => $imageName,
                ]);
        } else {
            Album::where('id', $validated['id'])
                ->update([
                    'name' => $validated['name'],
                    'artist_id' => $validated['artist'],
                    'description' => $validated['descr'],
                    'image' => $validated['image'],
                ]);
        }
        Log::channel('album_updates')
            ->info(
                'Был изменен альбом: {name}, пользователем: {user}.',
                [
                    'name' => $validated['name'],
                    'user' => Auth::user()->email,

                ]
            );
    }

    public function deleteAlbum(int $id): void
    {
        $album = Album::find($id);
        Album::where('id', $id)->delete();
        Storage::delete('album_image/' . $album->image);
        Log::channel('album_deletes')
            ->info(
                'Информация об альбоме {name} удалена.',
                ['name' => $album->name]
            );
    }

}
