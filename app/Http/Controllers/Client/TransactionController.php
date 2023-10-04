<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\Client\SongService;
use App\Services\Client\TransactionService;
use App\Services\Client\UserService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    protected $transaction;

    public function __construct(TransactionService $transaction)
    {
        $this->transaction = $transaction;
    }

    public function history($id)
    {
        $transactions = $this->transaction->getHistoryBuySong($id);

        if ($transactions == '404'){
            return  view('client.404');
        }

        return view('client.history', compact('transactions'));
    }
}
