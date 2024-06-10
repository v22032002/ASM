<?php

namespace Admin\PhpOop\Controllers\Client;

use Admin\PhpOop\Commons\Controller;
class HomeController extends Controller
{
    public function index() {
        $name = 'hihihaha';

        $this->renderViewClient('home', [
            'name' => $name
        ]);
    }
}