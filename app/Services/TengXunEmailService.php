<?php


namespace App\Services;


use App\Contracts\IEmailService;

class TengXunEmailService implements IEmailService
{
    public function send($message)
    {
        // ~~~~~~~~

        //  ~~~~~~~~~~~

        echo "Tenxun: 已发送邮件" . $message;
    }

    public function body($brothers)
    {
        echo "Tengxun: Body".$brothers ;
    }
}