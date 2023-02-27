<?php
require_once __DIR__ . '/../services/NavBarService.php';
class Controller {
    private $navBarService;

    public function __construct()
    {
        $this->navBarService=new NavBarService();
    }
    function displayView($model) {        
        $directory = strtolower(substr(get_class($this), 0, -10));
        $view = debug_backtrace()[1]['function'];
        require __DIR__ . "/../views/$directory/$view.php";
    }
    function displayPageView($view){
        $directory = strtolower(substr(get_class($this), 0, -10));
        require __DIR__ . "/../views/$directory/$view.php";
    }
    protected function parseDateOfBirth($date){
        $date = DateTime::createFromFormat('Y-m-d', $date);
        if ($date === false || array_sum($date->getLastErrors()) > 0) {
            return null;
        }
        return $date;
    }
}