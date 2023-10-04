<?php

namespace App\Services\Client;

use App\Models\Genre;
use App\Services\BaseService;

class GenreService extends BaseService
{

    public function getModel()
    {
        return Genre::class;
    }

    public function getHomeGenre()
    {
        return $this->model->orderByDesc('created_at')->take(HOME_GENRE)->get();
    }
}
