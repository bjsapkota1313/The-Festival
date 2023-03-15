<?php
// $restaurant
?>


<div id="r1" class="container restaurantContainer">
    <div class="restaurantNameField">
        <label class="restaurantNameRowLabel">
            Name:
        </label>
        <label class="restaurantNameRowValue">
            <?php
            echo $restaurant->getName();
            ?>
        </label>
    </div>
    <div class="restaurantLocationField">
        <label class="restaurantLocationRowLabel">
            Location:
        </label>
        <label class="restaurantLocationRowValue">
            <?php
            echo $restaurant->getLocation();
            ?>
        </label>
    </div>
    <div class="restaurantNumOfSeatsField">
        <label class="restaurantNumOfSeatsRowLabel">
            Number of Seats:
        </label>
        <label class="restaurantNumOfSeatsRowValue">
            <?php
            echo $restaurant->getNumberOfSeats();
            ?>
        </label>
    </div>
</div>