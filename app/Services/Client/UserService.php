<?php

namespace App\Services\Client;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Services\BaseService;
use App\Services\SendMai\MailService;
use Exception;

class UserService extends BaseService
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

    public function payment($request)
    {
        $remaining = $request->wallet - $request->price;

        if ($remaining < 0) {
            throw new \Exception(ADD_MONEY);
        }

        try {
            $this->update($request->user_id, ['wallet' => $remaining]);
        } catch (\Exception $e) {
            $this->update($request->user_id, ['wallet' => $request->wallet]);
            throw new \Exception('Your are download failed, please try again');
        }
    }

    public function storePlaylist($request)
    {
        $user = $this->find($request->user_id);

        if ($user->songs()->where('song_id', $request->song_id)->exists()) {
            throw new \Exception('The song already exist in the playlist');
        }

        try {
            $user->songs()->attach($request->song_id);
        } catch (Exception $e) {
            throw new \Exception('Add new failure song');
        }
    }

    public function register($request)
    {
        $user = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ];

        // try {
        //     MailService::sendMail($request->only(['name', 'email']));
        // } catch (Exception $th) {
        //     throw new Exception(SEND_MAIL_ERROR);
        // }

        try {
            DB::beginTransaction();
            $check = $this->create($user);
            DB::commit();
            return $check;
        } catch (\Exception $err) {
            DB::rollBack();
            Log::error('Message' . $err->getMessage() . 'Line :' . $err->getLine());
            throw new Exception(ERROR_500);
        }
    }
}
