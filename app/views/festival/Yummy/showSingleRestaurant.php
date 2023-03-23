<?php
// $restaurant
?>


<div class="container restaurantContainer">
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
    <div class="restaurantScoreField">
        <label class="restaurantScoreRowLabel">
            Score:
        </label>
        <label class="restaurantScoreRowValue">
            <?php
            echo $restaurant->getScore();
            ?>
        </label>
    </div>
    <div class="restaurantFoodTypesField">
        <label class="restaurantFoodTypesRowLabel">
            Food Types:
        </label>
        <label class="restaurantFoodTypesRowValue">
            <?php
            echo $restaurant->getFoodTypes();
            ?>
        </label>
    </div>
    <div class="container-fluid col-md-6 overflow-hidden p-0 restaurantImageCardDiv">
        <img 
        src="<?= $restaurant->getRestaurantCardImageFullPath() ?>"
        class="img-fluid h-100 restaurantImageCardImg"
        alt="Cover Image"
        >
    </div>
</div>