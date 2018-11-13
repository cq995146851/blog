<?php
/**
 * Created by PhpStorm.
 * User: 陈骞
 * Date: 2018/11/13
 * Time: 11:30
 */

namespace App\Handler;


use Illuminate\Support\Facades\Mail;

class Email
{
    public static function sendUserConfirm($emailData)
    {
        Mail::send($emailData['view'], $emailData['data'], function ($msg) use ($emailData) {
           $msg->to($emailData['to'])->subject($emailData['subject']);
        });
    }
}