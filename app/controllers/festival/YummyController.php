<?php
require_once __DIR__ . '/EventController.php';
require_once __DIR__ . '/../../models/user.php';
require_once __DIR__ . '/../../models/restaurant.php';
require_once __DIR__ . '/../../services/restaurantService.php';

class YummyController extends eventController {
    private $restaurantService;
    public function __construct()
    {
        parent::__construct();
        $this->restaurantService = new RestaurantService();
    }

    public function index(){
        $this->displayViewFestival(null);
    }


    public function restaurant($query) {
        // get all restaurants
        $restaurants = $this->restaurantService->getRestaurants();
        // print_r($restaurants);
        // $c = count($restaurants);
        // echo "Number of restaurants is {$c}";       
        $this->displayNavBar("Yummy",'/css/festival/yummy.css');
        // require __DIR__ . '/../../views/festival/History/index.php';
        $this->displayViewFestival($restaurants);
    }


    public function editRestaurantSubmitted() {
        // submitting new page or updating an existing page
        if(isset($_POST["formSubmit"])) {
            // save to database
            $restaurant = new Restaurant();
            // comment: correct URI later.
            $restaurant->setName($_POST['restaurantName']);
            $restaurant->setLocation($_POST['restaurantLocation']);
            $restaurant->setNumberOfSeats($_POST['restaurantNumberOfSeats']);
            $restaurant->setDescriptionHTML($_POST["tinyMCEform"]);
            
            // check if the page is a new page or updating existing page
            // if the pageID value exists in the submitted form, we are updating that page. If it does not exist, we are creating a new page.
            if(isset($_POST['restaurantID'])) {
                $this->restaurantService->updateRestaurantById($_POST['restaurantID'], $restaurant);

                $this->displayNavBar("Yummy",'/css/festival/yummy.css');

                echo "existing restaurant updated!";
            }
            else {
                $this->restaurantService->createNewRestaurant($restaurant);

                $this->displayNavBar("Yummy",'/css/festival/yummy.css');

                echo "new restaurant added!";
            }

            // show the user result.
            
            // $this->displayView($_POST["tinyMCEform"]);
        }
        // if the user has clicked the delete button
        else if(isset($_POST["formDelete"])) {
            $this->restaurantService->deleteRestaurantById($_POST['restaurantID']);
            echo "deleted restaurant with id " . $_POST['restaurantID'];   
        }
    }

    public function editRestaurant($query) {
        if (!isset($_SESSION["loggedUser"])) {
            // if user is not logged in, she cannot edit restaurants.
            header("location: /home");
            exit();
        }

        if (!unserialize(serialize($_SESSION["loggedUser"]))->getRole() == Roles::Administrator()) {
            // if user is not administrator, she cannot edit restaurants either
            header("location: /home");
            exit();
        }
        // first, we check for title in the query.
        parse_str($query, $parsedQuery);
        
        if(isset($parsedQuery["name"])) {
            // echo $parsedQuery["name"];
            $restaurant = $this->restaurantService->getRestaurantByName($parsedQuery["name"]);
            // print_r($restaurant);
            if($restaurant != null) {

                $this->displayNavBar("Yummy",'/css/festival/yummy.css');

                $this->displayViewFestival($restaurant);
            }
            else {
                // page not found

                $this->displayNavBar("Yummy",'/css/festival/yummy.css');

                $this->displayViewFestival(null);
            }
        }
        else {

            $this->displayNavBar("Yummy",'/css/festival/yummy.css');

            $this->displayViewFestival(null);
        }
    }

}