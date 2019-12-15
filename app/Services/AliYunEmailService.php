<?php


namespace App\Services;


use App\Contracts\IEmailService;

class AliYunEmailService implements IEmailService
{


    public function send($message)
    {
        // ~~~~~~~~

        //  ~~~~~~~~~~~

        echo "ALIYUN: 已发送邮件" . $message;
    }


    public function body($brothers)
    {
        echo "ALIYUN: 你真的很不错".$brothers ;
        // TODO: Implement body() method.
    }
}