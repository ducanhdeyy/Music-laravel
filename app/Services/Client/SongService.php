<?php

namespace App\Services\Client;

use App\Models\Song;
use App\Services\BaseService;
use Exception;

class SongService extends BaseService
{

    public function getModel(): string
    {
        return Song::class;
    }

    public function getSong()
    {
        try {
            return $this->model->with('singer')->search()->orderByDesc('created_at')->paginate(SONG);
        }catch (\Exception $e){
            throw new Exception(ERROR_500);
        }
    }

    public function getTopTrack()
    {
        try {
            return $this->model->with('singer')->orderByDesc('created_at')->take(TOP_TRACK_SONG)->get();
        }catch (\Exception $e){
            throw new Exception(ERROR_500);
        }
    }

    public function getTopTracks()
    {
        try {
            return $this->model->with('singer')->orderByDesc('created_at')->take(TOP_TRACK_SONGS)->get();
        }catch (\Exception $e){
            throw new Exception(ERROR_500);
        }
    }

    public function getRecently()
    {
        try {
            return $this->model->with('singer')->orderByDesc('created_at')->take(RECENTLY_SONG)->get();
        }catch (\Exception $e){
            throw new Exception(ERROR_500);
        }
    }

    public function getChart()
    {
        try {
            return $this->model->with('singer')->search()->orderByDesc('created_at')->paginate(CHART);
        }catch (\Exception $e){
            throw new Exception(ERROR_500);
        }
    }
}
