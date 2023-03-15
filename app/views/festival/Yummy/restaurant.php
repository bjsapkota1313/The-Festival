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
    <div class="restaurantPage1">
      <label>
        List of restaurants
      </label>
  </div>
    <div class="container col-sm-12 col-md-6 col-lg-4">
        <?php
        foreach ($restaurants as $restaurant) {
            include("showSingleRestaurant.php");
        }
        ?>
    </div>
  </body>
</html>
