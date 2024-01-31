<?php

namespace App\Repositories;

use App\Interfaces\ArtistRepositoryInterface;
use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

use Illuminate\Pagination\LengthAwarePaginator;


class ArtistRepository implements ArtistRepositoryInterface
{
    public function getArtists(): ?LengthAwarePaginator
    {
        return Artist::paginate(5);
    }

    public function filterByName(string $name): LengthAwarePaginator
    {
        return Artist::where('name', 'LIKE', "%{$name}%")
            ->paginate(5);
    }

    public function getArtistsForList(): Collection
    {
        return Artist::all();
    }

    public function createArtist(array $validated, string $imageName): bool
    {
        $result = Artist::create([
            'name' => $validated['name'],
            'image' => $imageName,
        ]);
        return $result->exists();
    }

    public function getArtist(int $id): Artist
    {
        return Artist::find($id);
    }

    public function updateArtist(array $validated, string $imageName): bool
    {
        $result = Artist::where('id', $validated['id'])
            ->update([
                'name' => $validated['name'],
                'image' => $imageName,
            ]);
        return $result;
    }

    public function deleteArtist(int $id): Artist
    {
        $artist = $this->getArtist($id);
        Artist::where('id', $id)->delete();
        return $artist;
    }

}
