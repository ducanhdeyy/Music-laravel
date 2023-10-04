<?php

namespace App\Services\Client;

use App\Models\Album;
use App\Services\BaseService;

class AlbumService extends BaseService
{

    public function getModel()
    {
        return Album::class;
    }

    public function getHomeAlbum()
    {
        return $this->model->orderByDesc('created_at')->take(HOME_ALBUM)->get();
    }
}
