<?php

namespace controllers;

use core\BaseController;

class HomeController extends BaseController {
    public function index() {
      
        $this->render('home', [
            'title' => 'Home'
        ]);
        
    }

    public function login() {
        session_start();
        $_SESSION['user'] = 'John Doe';
        $this->route('user');
    }
}