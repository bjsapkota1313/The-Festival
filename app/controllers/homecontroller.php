<?php

class HomeController
{
    public function index()
    {

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