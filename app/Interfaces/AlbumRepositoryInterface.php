<?php

namespace App\Interfaces;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface AlbumRepositoryInterface
{
    public function getAlbums(Request $request): ?LengthAwarePaginator;
    public function findByArtist(int $id): LengthAwarePaginator;
    public function createAlbum(array $validated): void;
    public function getAlbum(int $id): Model;
    public function updateAlbum(array $validated): void;
    public function deleteAlbum(int $id): void;
}
