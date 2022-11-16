<?php

namespace App\Http\Controllers\Mail;

use Illuminate\Http\Request;
use App\Mail\NewPasswordMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class NewPasswordController extends Controller
{
    public function showNewPasswordEmail(){
        Mail::to('orbinobrian0506@gmail.com','Brian Orbs')->queue(new NewPasswordMail());
        return new NewPasswordMail();
    }
}
