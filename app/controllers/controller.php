<?php
require_once __DIR__ . '/../services/NavBarService.php';
 abstract class Controller {
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
    protected function sanitizeInput($input) {
        return htmlspecialchars($input);
    }
    protected function display404PageNotFound():void{
        require_once __DIR__.'/../views/PageNotFound.html';
        return;
     }
   
      protected function displayFooter(): void
    {
        require_once __DIR__.'/../views/Footer.php';
    }
     /**
      * Validates and sanitizes input fields.
      *
      * @param array $inputArray The input array to be checked and sanitized.
      * @param array $excludedKeys An array of keys to be excluded from validation and sanitization like buttons or fields that you dont want to use it for now .
      * @param array $checkBoxKeys An array of checkbox keys that must be present in the input array.
      *
      * @return array|string Returns an array of sanitized input fields if all fields are valid and sanitized, otherwise
      * returns a string error message indicating which fields are missing or invalid.
      */
      protected function checkFieldsFilledAndSantizeInput(array $inputArray, array $excludedKeys = [], array $checkBoxKeys = []): array|string
     {
         $sanitizedInputArray = [];
         if(!empty($checkBoxKeys)){
             $MissingCheckBoxesFields = $this->getMissingCheckBoxFields($inputArray, $checkBoxKeys);

             if (!empty($MissingCheckBoxesFields)) {
                 $MissingCheckBoxesFields = implode(", ", $MissingCheckBoxesFields);
                 return "Please fill the following fields: " . $MissingCheckBoxesFields;
             }
         }
         foreach ($inputArray as $key => $value) {
             if (empty($value) && !in_array($key, $excludedKeys)) {
                 return "Please enter a value for the field " . $key;
             }

             if (!in_array($key, $excludedKeys)) {
                 $sanitizedInputArray[$key] = $value;
                 if (is_array($value)) {
                     $newValue = [];
                     foreach ($value as $subKey => $subValue) {
                         $newValue[$subKey] = $this->sanitizeInput($subValue);
                     }
                     $sanitizedInputArray[$key] = $newValue;
                 } else {
                     $sanitizedInputArray[$key] = $this->sanitizeInput($value);
                 }
             }
         }

         return $sanitizedInputArray;
     }
     private function getMissingCheckBoxFields(array $inputArray, array $checkBoxKeys): array
     {
         $missingCheckBoxFields = [];
         foreach ($checkBoxKeys as $checkBoxKey) {
             if (!array_key_exists($checkBoxKey, $inputArray)) {
                 $missingCheckBoxFields[] = $checkBoxKey;
             }
         }
         return $missingCheckBoxFields;
     }
 }

