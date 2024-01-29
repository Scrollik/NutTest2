<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface ArtistRepositoryInterface
{
    public function getArtists(array $validated): ?LengthAwarePaginator;
    public function getArtist(int $id): Model;
    public function getArtistsForList(): Collection;
    public function createArtist(array $validated): void;
    public function deleteArtist(int $id): void;
}
