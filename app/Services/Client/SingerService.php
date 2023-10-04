<?php

namespace App\Services\Client;

use App\Models\Singer;
use App\Services\BaseService;

class SingerService extends BaseService
{

    public function getModel()
    {
        return Singer::class;
    }

    public function getHomeSinger()
    {
        try {
            return $this->model->orderByDesc('created_at')->take(HOME_SINGER)->get();
        } catch (\Exception $e) {
            throw new \Exception(ERROR_500);
        }

    }

    public function getArtists()
    {
        return $this->model->orderByDesc('created_at')->paginate(ARTISTS);
    }
}
