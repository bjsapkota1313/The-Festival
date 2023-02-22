<?php
require __DIR__ . '/controller.php';

class ManageInformationController extends Controller
{
    public function index()
    {
        $this->displayPageView('ManageInformationOverview');
    }
}