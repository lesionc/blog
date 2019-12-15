<?php

namespace App\Http\Controllers;

use App\Contracts\IEmailService;
use Illuminate\Http\Request;

class TestController extends Controller
{

    private $emailService;

    public function __construct(IEmailService $emailService)
    {
        $this->emailService = $emailService;
    }


    public function index()
    {
        $this->emailService->send("benben1111111111111111");
        $this->emailService->body("xiaoyan");
    }

}
