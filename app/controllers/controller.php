<?php
class Controller {
    function displayView($model) {        
        $directory = strtolower(substr(get_class($this), 0, -10));
        $view = debug_backtrace()[1]['function'];
        require __DIR__ . "/../views/$directory/$view.php";
    }
    function displayPageView($view, $model) {
        $directory = strtolower(substr(get_class($this), 0, -10));
        require __DIR__ . "/../views/$directory/$view.php";
    }
}