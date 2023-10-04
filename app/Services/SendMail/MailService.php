<?php

namespace App\Services\SendMai;

use App\Models\User;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;

class MailService
{
    public static function sendMail($user)
    {
        dd($user);
        try {
            //code...
        } catch (\Throwable $th) {
            //throw $th;
        }
        $mail = new SendMail($user);

        return Mail::to('dinhcan355@gmail.com')->queue($mail);
    }
}
