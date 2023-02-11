<?php
session_start();
class PatternRouter
{
    private function stripParameters($uri)
    {
        // checks if $uri contains ?, which shows the $uri contains parameters.
        if (str_contains($uri, '?')) {
            // using strpos find the locations of starting parameters (?) and return from pos 0 to there with substr.
            $uri = substr($uri, 0, strpos($uri, '?'));
        }
        return $uri;
    }

    private function getQueries($uri) {
        if (str_contains($uri, '?')) {
            return substr($uri, strpos($uri, '?'));
        }
        else {
            return "";
        }
    }

    public function route($uri)
    {
        // exclude javascript and css fils.
        if (
            str_ends_with($uri, ".js")
            || str_ends_with($uri, ".css")
        ) {
            readfile(__DIR__ . "/" . $uri);
            die();
        }
        // Path algorithm
        // pattern = /controller/method
        // check if we are requesting an api route
        $api = false;
        if (str_starts_with($uri, "api/")) {
            $uri = substr($uri, 4);
            $api = true;
        }

        // set default controller/method
        $defaultcontroller = 'home';
        $defaultmethod = 'index';

        // ignore query parameters
        $queries = $this->getQueries($uri);
        $uri = $this->stripParameters($uri);

        // read controller/method names from URL
        // eplode is similar to split in C#, so it creates an array of strings, so
        // home/about, turns to
        // ["home", "about"]
        $explodedUri = explode('/', $uri);
        // if the first element is null or empty, set it to "home".
        if (!isset($explodedUri[0]) || empty($explodedUri[0])) {
            $explodedUri[0] = $defaultcontroller;
        }
        $controllerName = $explodedUri[0] . "Controller";

        // . (dot) in php for strings is concatination. Similar to + in C#.
        // $controllerName becomes "homecontroller"
        $controllerName = $explodedUri[0] . "controller";

        if (!isset($explodedUri[1]) || empty($explodedUri[1])) {
            $explodedUri[1] = $defaultmethod;
        }
        // $methodName becomes "about"
        $methodName = $explodedUri[1];

        // $filename becomes ./../controllers/homecontroller.php
        $filename = __DIR__ . '/../controllers/' . $controllerName . '.php';

        if ($api) {
            $filename = __DIR__ . '/../api/controllers/' . $controllerName . '.php';
        }

        // check if the $filename exists. Here, the homecontroller.php in the controllers folder.
        if (file_exists($filename)) {
            // require is similar to import in C#.
            require($filename);
            try {
                // create a new instance from the class controllerName.
                // $controllerObj = new $controllerName();
                $controllerObj = new $controllerName;
                // call the methodName in the class controllerName
                $controllerObj->{$methodName}($queries);
                // $controllerObj->$methodName();
            } catch(Error $e) {
                // For some reason the class/method doesn't load
                echo "error";
                echo $e;
                http_response_code(500);
                die();
            }
        } else {
            // Controller/method matching the URL not found
            http_response_code(404);
            die();
        }
    }
}