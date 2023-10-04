<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\Client\UserService;
use App\Services\Client\AlbumService;
use App\Services\Client\GenreService;
use App\Services\Client\SingerService;
use App\Services\Client\SongService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $album;
    protected $song;
    protected $singer;
    protected $genre;
    protected $user;

    public function __construct(UserService $user, SongService $song, SingerService $singer, GenreService $genre, AlbumService $album)
    {
        $this->album = $album;
        $this->song = $song;
        $this->singer = $singer;
        $this->genre = $genre;
        $this->user = $user;
    }

    public function index()
    {
        $songs = $this->song->getTopTracks();
        $newSongs = $this->song->getRecently();
        $albums = $this->album->getHomeAlbum();
        $singers = $this->singer->getHomeSinger();
        $genres = $this->genre->getHomeGenre();

        return view('client.home', compact('songs', 'albums', 'singers', 'genres', 'newSongs'));
    }

    public function download(Request $request)
    {
        try {
            $this->user->payment($request);
            return response()->download(public_path('uploads/' . $request->url));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function charts()
    {
        try {
            $songs = $this->song->getChart();
            return view('client.charts', compact('songs'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function artists()
    {
        try {
            $singers = $this->singer->getArtists();
            return view('client.artists', compact('singers'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function singerSong($id)
    {
        try {
            $singer = $this->singer->find($id);
            dd($singer->songs);
            $topTracks = $this->song->getTopTracks();
            return view('client.singer', compact('singer', 'topTracks'));
        } catch (ModelNotFoundException $e) {
            return view('client.404');
        }
    }
}
