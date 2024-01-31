<?php

namespace App\Interfaces;

use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface AlbumRepositoryInterface
{
    public function getAlbums(): ?LengthAwarePaginator;

    public function findByArtist(int $id): LengthAwarePaginator;

    public function createAlbum(array $validated, string $imageName): bool;

    public function getAlbum(int $id): Album;

    public function updateAlbum(array $validated, string $imageName): bool;

    public function deleteAlbum(int $id): Album;
}
