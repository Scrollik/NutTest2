<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAlbumRequest;
use App\Http\Requests\UpdateAlbumRequest;
use App\Services\AlbumService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AlbumController extends Controller
{
    public function __construct(AlbumService $albumService)
    {
        $this->AlbumService = $albumService;
    }

    public function index(Request $request): View
    {
        $albums = $this->AlbumService->getAlbums($request);
        $artists = $this->AlbumService->getArtists();
        return view('welcome', compact('albums','artists'));
    }

    public function create(): View
    {
        $artists = $this->AlbumService->getArtists();
        return view('album.new_album',compact('artists'));
    }

    public function findAlbumApi(Request $request): JsonResponse
    {
        return $this->AlbumService->findAlbumApi($request);
    }

    public function store(StoreAlbumRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $this->AlbumService->storeAlbum($validated);
        return redirect('/');
    }

    public function edit(string $id): View
    {
        $album = $this->AlbumService->getAlbum($id);
        $artists = $this->AlbumService->getArtists();
        return view('album.update_album', compact('album','artists'));
    }

    public function updateAlbum(UpdateAlbumRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $this->AlbumService->updateAlbum($validated);
        return redirect('/');
    }

    public function destroy(string $id): RedirectResponse
    {
        $this->AlbumService->deleteAlbum($id);
        return redirect('/');
    }
}
