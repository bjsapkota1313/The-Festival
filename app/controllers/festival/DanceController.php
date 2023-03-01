<?php
require_once __DIR__ . '/EventController.php';
class DanceController extends eventController {

    public function index(){
        require __DIR__ . '/../../views/festival/Dance/index.html';

    }
    public function artist(){
       require __DIR__ . '/../../views/festival/Dance/artist.html';
    }

}