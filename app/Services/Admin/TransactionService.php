<?php

namespace App\Services\Admin;

use App\Models\Transaction;
use App\Services\BaseService;
use Exception;

class TransactionService extends BaseService
{

    public function getModel()
    {
        return Transaction::class;
    }

    public function index()
    {
        try {
            return $this->model->with('user', 'song')->search()->orderByDesc('created_at')->paginate(INDEX_TRANSACTION);
        } catch (\Throwable $th) {
            throw new Exception(ERROR_500);
        }
    }
}
