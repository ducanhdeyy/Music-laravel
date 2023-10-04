<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\Client\SongService;
use Illuminate\Http\Request;

class SongController extends Controller
{
    private $song;

    public function __construct(SongService $song)
    {
        $this->song = $song;
    }
    public function index()
    {
        $songs = $this->song->getSong();
        return view('client.song', compact('songs'));
    }
}
