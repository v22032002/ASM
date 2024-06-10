<?php

namespace Admin\PhpOop\Controllers\Admin;

use Admin\PhpOop\Commons\Controller;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $this->renderViewAdmin(__FUNCTION__);
    }
}
