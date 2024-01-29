<?php

namespace App\Repositories;

use App\Interfaces\ArtistRepositoryInterface;
use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ArtistRepository implements ArtistRepositoryInterface
{
    protected Artist $ArtistInfo;

    public function __construct(Artist $ArtistInfo)
    {
        $this->Artist = $ArtistInfo;
    }

    public function getArtists(array $validated): ?LengthAwarePaginator
    {
        if (!empty($validated))
        {
            return $this->filterByName($validated['artist_name']);

        }else{
            return Artist::paginate(5);
        }
    }
    public function filterByName(string $name): LengthAwarePaginator
    {
        return Artist::where('name','LIKE' ,"%{$name}%")
            ->paginate(5);
    }
    public function getArtistsForList(): Collection
    {
        return Artist::all();
    }

    public function createArtist(array $validated): void
    {
        if (!empty($validated['yourImage'])) {
            $image = $validated['yourImage'];
            $imageName = $validated['yourImage']->getClientOriginalName();
            $image->move('artist_image', $imageName);
            Artist::create([
                'name' => $validated['name'],
                'image' => $imageName,
            ]);
        } else {
            $contents = file_get_contents($validated['image']);
            $imageName = substr($validated['image'], strrpos($validated['image'], '/') + 1);
            Storage::disk('artist_image')->put($imageName, $contents);
            Artist::create([
                'name' => $validated['name'],
                'image' => $imageName,
            ]);
        }
        Log::channel('artist_creates')->info(
            'Пользователь {user} создал исполнителя {name}',
            [
                'name' => $validated['name'],
                'user' => Auth::user()->email,
            ]
        );
    }

    public function getArtist(int $id): Model
    {
        return Artist::find($id);
    }

    public function updateArtist(array $validated)
    {
        $artist = $this->getArtist($validated['id']);
        if (!empty($validated['new_image'])) {
            Storage::delete('artist_image/' . $artist->image);
            $image = $validated['new_image'];
            $imageName = $validated['new_image']->getClientOriginalName();
            $image->move('Artist_image', $imageName);
            Artist::where('id', $validated['id'])
                ->update([
                    'name' => $validated['name'],
                    'image' => $imageName,
                ]);
        } else {
            $contents = file_get_contents($validated['image']);
            $imageName = substr($validated['image'], strrpos($validated['image'], '/') + 1);
            Storage::delete('artist_image/' . $artist->image);
            Storage::disk('artist_image')->put($imageName, $contents);
            Artist::where('id', $validated['id'])
                ->update([
                    'name' => $validated['name'],
                    'image' => $imageName,
                ]);
        }
        Log::channel('artist_updates')
            ->info(
                'Был изменен исполнитель: {name}, пользователем: {user}.',
                [
                    'name' => $validated['name'],
                    'user' => Auth::user()->email,
                ]
            );
    }

    public function deleteArtist(int $id): void
    {
        $artist = Artist::find($id);
        Artist::where('id', $id)->delete();
        Storage::delete('artist_image/' . $artist->image);
        Log::channel('artist_deletes')
            ->info(
                'Информация об альбоме {name} удалена.',
                ['name' => $artist->name]
            );
    }

}
