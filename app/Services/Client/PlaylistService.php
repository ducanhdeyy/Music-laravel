<?php

namespace App\Services\Client;


use App\Models\User;
use App\Services\BaseService;
use Exception;

class PlaylistService extends BaseService
{

    public function getModel()
    {
        return User::class;
    }

    public function getPlaylist($id)
    {
        $user = $this->find($id);

        try {
            return $user->songs;
        } catch (\Throwable $th) {
            throw new Exception(ERROR_500);
        }
    }

    public function storePlaylist($request)
    {
        $user = $this->find($request->user_id);

        if ($user->songs()->where('song_id', $request->song_id)->exists()) {
            throw new \Exception(ADD_PLAYLIST_FAILED);
        }

        try {
           return $user->songs()->attach($request->song_id);
        } catch (Exception $e) {
            throw new Exception(ERROR_500);
        }
    }

    public function deletePlaylist($request)
    {
        $user = $this->find($request->user_id);
        try {
            if ($user->songs()->where('song_id', $request->song_id)->exists()) {
               return $user->songs()->detach($request->song_id);
            }
        } catch (\Throwable $th) {
            throw new Exception(ERROR_500);
        }
    }
}
