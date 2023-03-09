<?php
require_once __DIR__ . '/../services/NavBarService.php';
class Controller {
    private NavBarService $navBarService;

    public function __construct()
    {
        $this->navBarService=new NavBarService();
    }
    function displayView($model) {        
        $directory = strtolower(substr(get_class($this), 0, -10));
        $view = debug_backtrace()[1]['function'];
        require __DIR__ . "/../views/$directory/$view.php";
    }
    // since festival files are inside a folder, the path is different.
    function displayViewFestival($model) {        
        $directory = strtolower(substr(get_class($this), 0, -10));
        $view = debug_backtrace()[1]['function'];
        require __DIR__ . "/../views/festival/$directory/$view.php";
    }
    function displayPageView($view){
        $directory = strtolower(substr(get_class($this), 0, -10));
        require __DIR__ . "/../views/$directory/$view.php";
    }
    // since festival files are inside a folder, the path is different.
    function displayPageViewFestival($view){
        $directory = strtolower(substr(get_class($this), 0, -10));
        require __DIR__ . "/../views/festival/$directory/$view.php";
    }
    protected function parseDateOfBirth($date): bool|string
    {
        $current_date = new DateTime();
        $birthDate = DateTime::createFromFormat('Y-m-d', $date);
        if ($birthDate===false ||array_sum($birthDate->getLastErrors()) > 0) {
            return "please input a valid date format (YYYY-MM-DD) for birthdate";
        } else if ($date > $current_date) {
            return  "Please select a date that is not in the future";
        }
        return true;
    }
    protected function displayNavBar($title,$pathToCss): void
    {
        $this->navBarService=new NavBarService();
        $navBarItems=$this->navBarService->getAllNavBarItems();
        require_once __DIR__.'/../views/HomeNavBar.php';
    }
    
       function displayViewUsingPermissions($model, $user) {        
        $directory = strtolower(substr(get_class($this), 0, -10));
        $view = debug_backtrace()[1]['function'];
        $currentUserId = $user;
        $pageId = func_get_arg(2);
        require __DIR__ . "/../views/$directory/$view.php";
    }
}
