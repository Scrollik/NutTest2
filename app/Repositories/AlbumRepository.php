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
    public function getAlbums(): ?LengthAwarePaginator
    {
        return Album::with('artist')
            ->paginate(5);
    }

    public function findByArtist(int $id): LengthAwarePaginator
    {
        return Album::where('artist_id', $id)
            ->with('artist')
            ->paginate(5);
    }

    public function createAlbum(array $validated, string $imageName): bool
    {
       $album = Album::create([
            'name' => $validated['name'],
            'artist_id' => $validated['artist'],
            'description' => $validated['descr'],
            'image' => $imageName,
        ]);
        return $album->exists();
    }

    public function getAlbum(int $id): Album
    {
        return Album::where('id', $id)
            ->with('artist')
            ->first();
    }

    public function updateAlbum(array $validated, string $imageName): bool
    {
        $updateAlbum = Album::where('id', $validated['id'])
            ->update([
                'name' => $validated['name'],
                'artist_id' => $validated['artist'],
                'description' => $validated['descr'],
                'image' => $imageName,
            ]);
        return $updateAlbum;
    }

    public function deleteAlbum(int $id): Album
    {
        $album = Album::find($id);
        Album::where('id', $id)->delete();
        return $album;
    }

}
