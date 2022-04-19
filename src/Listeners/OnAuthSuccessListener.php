<?php

namespace App\Listeners;

class OnAuthSuccessListener {

    public function onAuthenticationSuccess(){
        dd("Authentication sucess");
    }
}