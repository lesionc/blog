<?php


namespace App\Contracts;


interface IEmailService
{
    public function send($message);

    public function body($brothers);
}