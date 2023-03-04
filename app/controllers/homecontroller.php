<?php
require_once __DIR__ . '/controller.php';

class HomeController extends Controller
{
    public function index()
    {
        require __DIR__ . '/../views/home/index.php';
    }

    public function about()
    {
        require __DIR__ . '/../views/home/about.php';

    }

    public function test()
    {
        echo "this is a test";
    }
}
