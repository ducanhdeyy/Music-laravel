<?php

namespace App\Services\Client;

use App\Models\Song;
use App\Models\Transaction;
use App\Models\User;
use App\Services\BaseService;
use Illuminate\Support\Facades\Auth;

class TransactionService extends BaseService
{

    public function getModel(): string
    {
        return Transaction::class;
    }

    public function getHistoryBuySong($id)
    {
        if (Auth::guard('cus')->id() != $id){
            return 404;
        }

        return $this->model->with('song.singer')->orderByDesc('created_at')->where('user_id', $id)->paginate(HISTORY_BUY_SONG);
    }

}
