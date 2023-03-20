<?php
// session_start()
if(isset($model) && $model != null) {
  $restaurants = $model;
}
else {
  $restaurants = null;
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Festival</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  </head>

  <body>
    <div class="restaurantCards container col-sm-12 col-md-9 col-lg-6">
    <div class="addRestaurantDiv">
        <?php
        if (isset($_SESSION["loggedUser"]) && unserialize(serialize($_SESSION["loggedUser"]))->getRole() == Roles::Administrator()) {
        ?>
        <a class="restaurantAddLink" href="/festival/Yummy/editRestaurant"> Add New Restaurant </a>
        <?php
        }
        ?>
    </div>
    <form action="/festival/Yummy/restaurant" method="POST">
      <div class="form-floating mb-3">
        <input type="text"
        class="form-control"
        name="restaurantFoodTypesSearch"
        id="restaurantFoodTypesSearch"
        placeholder="Search Food Types. Separate by comma"
        >
        <label for="restaurantFoodTypesSearch">Food Types. Separate by comma.</label>
      </div>
      
      <div class="form-floating mb-3">
        <button class="btn mb-2" name="searchSubmit" type="submit">
          Search
        </button>
      </div>
    </form>
        
        <?php
        if($restaurants != null && count($restaurants) > 0) {
          foreach ($restaurants as $restaurant) {
            include("showSingleRestaurant.php");
          }
        }
        ?>
    </div>
  </body>
</html>
