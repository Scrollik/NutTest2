<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterByNameRequest;
use App\Http\Requests\StoreArtistRequest;
use App\Http\Requests\UpdateArtistRequest;
use App\Services\ArtistService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArtistController extends Controller
{
    public function __construct(ArtistService $artistService)
    {
        $this->ArtistService = $artistService;
    }

    public function index(FilterByNameRequest $request): View
    {
        $validated = $request->validated();
        $artists = $this->ArtistService->getArtists($validated);
        return view('artist.artists', compact('artists'));
    }

    public function create(): View
    {
        return view('artist.new_artist');
    }

    public function findArtistApi(Request $request): JsonResponse
    {
        return $this->ArtistService->findArtistApi($request);
    }

    public function store(StoreArtistRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $this->ArtistService->storeArtist($validated);
        return redirect('/artists');
    }

    public function edit(string $id): View
    {
        $artist = $this->ArtistService->getArtist($id);
        return view('artist.update_artist', compact('artist'));
    }

    public function update(UpdateArtistRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $this->ArtistService->updateArtist($validated);
        return redirect('/artists');
    }

    public function destroy(string $id): RedirectResponse
    {
        $this->ArtistService->deleteArtist($id);
        return redirect()->route('artist.index');
    }
}
