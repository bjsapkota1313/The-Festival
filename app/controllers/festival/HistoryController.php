<?php
require_once __DIR__ . '/EventController.php';
class HistoryController extends EventController
{
    public function index(){
        $this->displayNavBar("A stroll Through History",'/css/festival/history.css');
        require __DIR__ . '/../../views/festival/History/index.php';
    }
    public function detail(){
        $this->displayNavBar("A stroll Through History",'/css/festival/history.css');
        require __DIR__ . '/../../views/festival/History/detail.php';
    }
}