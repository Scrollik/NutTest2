<?php

namespace App\Interfaces;

use App\Models\Artist;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface ArtistRepositoryInterface
{
    public function getArtists(): ?LengthAwarePaginator;

    public function getArtist(int $id): Model;

    public function getArtistsForList(): Collection;

    public function createArtist(array $validated, string $imageName): bool;

    public function updateArtist(array $validated, string $imageName): bool;

    public function deleteArtist(int $id): Model;
}
