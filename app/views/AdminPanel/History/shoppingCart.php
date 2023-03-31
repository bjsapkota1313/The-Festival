<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/22097c36aa.js" crossorigin="anonymous"></script>
    <meta name="description" content="">
    <meta name="author" content="">
    <script type="text/javascript"
            src="http://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js">
    </script>
    <script src="http://code.jquery.com/jquery-migrate-1.1.1.js"></script>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/css/Admin/AdminPanelSideBar.css">
    <!-- Boxiocns CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<section class="h-100 h-custom" style="background-color: #d2c9ff;">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12">
                <div class="card card-registration card-registration-2" style="border-radius: 15px;">
                    <div class="card-body p-0">
                        <div class="row g-0">

                            <div class="col-lg-8">
                                <div class="p-5">
                                    <div class="d-flex justify-content-between align-items-center mb-5">
                                        <h1 class="fw-bold mb-0 text-black">Shopping Cart</h1>
                                        <h6 class="mb-0 text-muted">3 items</h6>
                                    </div>
                                    <hr class="my-4">
                                    <?php foreach ($allItemsInShoppingCarts as $allItemsInShoppingCart) {
                                        ?>
                                        <div class="row mb-4 d-flex justify-content-between align-items-center">
                                            <div class="col-md-2 col-lg-2 col-xl-2">
                                                    <h6 class="text-muted"><?= $allItemsInShoppingCart->getLanguage() ?></h6>
                                            </div>
                                            <div class="col-md-3 col-lg-3 col-xl-3">
                                                <h6 class="text-muted"><?= $allItemsInShoppingCart->getTicketType() ?></h6>
                                            </div>
                                            <div id="orderItemContainer<?= $allItemsInShoppingCart->getOrderItemId() ?>" class="col-md-3 col-lg-3 col-xl-3 d-flex">
                                                <button class="btn btn-decreaseQuantity px-2" onclick="updateQuantity('<?= $allItemsInShoppingCart->getOrderItemId() ?>', document.getElementById('quantityForm<?= $allItemsInShoppingCart->getOrderItemId() ?>').value - 1)">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                                <input id="quantityForm<?= $allItemsInShoppingCart->getOrderItemId() ?>" min="0" name="quantity" value="<?= $allItemsInShoppingCart->getQuantity() ?>" type="number" class="form-control form-control-sm" data-itemid="<?= $allItemsInShoppingCart->getOrderItemId() ?>"/>
                                                <button class="btn btn-increaseQuantity px-2" onclick="updateQuantity('<?= $allItemsInShoppingCart->getOrderItemId() ?>', parseInt(document.getElementById('quantityForm<?= $allItemsInShoppingCart->getOrderItemId() ?>').value) + 1)">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                            <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1">
                                                <h6 class="mb-0"><?= $totalPrice = $allItemsInShoppingCart->getPrice() * $allItemsInShoppingCart->getQuantity(); ?></h6>
                                            </div>
                                            <div class="col-md-1 col-lg-1 col-xl-1 text-end">
                                                <a href="#!" class="text-muted"><i class="fas fa-times"></i></a>
                                            </div>
                                        </div>

                                        <hr class="my-4">
                                        
                                    <?php } ?>
                                    <?php foreach ($allRestaurantItems as $allRestaurantItem) {
                                        ?>
                                        <div class="row mb-4 d-flex justify-content-between align-items-center">
                                            <div class="col-md-2 col-lg-2 col-xl-2">
                                                    <h6 class="text-muted"><?= $allRestaurantItem->getRestaurantName() ?></h6>
                                            </div>
                                            <div class="col-md-3 col-lg-3 col-xl-3">
                                                <h6 class="text-muted"><?= $allRestaurantItem->getRestaurantName() ?></h6>
                                            </div>
                                            <div id="orderItemContainer<?= $allRestaurantItem->getOrderItemId() ?>" class="col-md-3 col-lg-3 col-xl-3 d-flex">
                                                <button class="btn btn-decreaseQuantity px-2" onclick="updateQuantity('<?= $allRestaurantItem->getOrderItemId() ?>', document.getElementById('quantityForm<?= $allRestaurantItem->getOrderItemId() ?>').value - 1)">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                                <input id="quantityForm<?= $allRestaurantItem->getOrderItemId() ?>" min="0" name="quantity" value="<?= $allRestaurantItem->getQuantity() ?>" type="number" class="form-control form-control-sm" data-itemid="<?= $allRestaurantItem->getOrderItemId() ?>"/>
                                                <button class="btn btn-increaseQuantity px-2" onclick="updateQuantity('<?= $allRestaurantItem->getOrderItemId() ?>', parseInt(document.getElementById('quantityForm<?= $allRestaurantItem->getOrderItemId() ?>').value) + 1)">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                            <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1">
                                                <h6 class="mb-0"><?= $totalPrice = $allRestaurantItem->getPrice() * $allRestaurantItem->getQuantity(); ?></h6>
                                            </div>
                                            <div class="col-md-1 col-lg-1 col-xl-1 text-end">
                                                <a href="#!" class="text-muted"><i class="fas fa-times"></i></a>
                                            </div>
                                        </div>

                                        <hr class="my-4">
                                    <?php } ?>

                                    <div class="pt-5">
                                        <h6 class="mb-0"><a href="#!" class="text-body"><i
                                                        class="fas fa-long-arrow-alt-left me-2"></i>Back to shop</a>
                                        </h6>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 bg-grey">
                                <div class="p-5">
                                    <h3 class="fw-bold mb-5 mt-2 pt-1">Summary</h3>
                                    <hr class="my-4">

                                    <div class="d-flex justify-content-between mb-4">
                                        <h5 class="text-uppercase">items 3</h5>
                                        <h5>€ 132.00</h5>
                                    </div>

                                    <h5 class="text-uppercase mb-3">Shipping</h5>

                                    <div class="mb-4 pb-2">
                                        <select class="select">
                                            <option value="1">Standard-Delivery- €5.00</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                            <option value="4">Four</option>
                                        </select>
                                    </div>

                                    <h5 class="text-uppercase mb-3">Give code</h5>

                                    <div class="mb-5">
                                        <div class="form-outline">
                                            <input type="text" id="form3Examplea2"
                                                   class="form-control form-control-lg"/>
                                            <label class="form-label" for="form3Examplea2">Enter your code</label>
                                        </div>
                                    </div>

                                    <hr class="my-4">

                                    <div class="d-flex justify-content-between mb-5">
                                        <h5 class="text-uppercase">Total price</h5>
                                        <h5>€ 137.00</h5>
                                    </div>

                                    <button type="button" class="btn btn-dark btn-block btn-lg"
                                            data-mdb-ripple-color="dark">Register
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    @media (min-width: 1025px) {
        .h-custom {
            height: 100vh !important;
        }
    }

    .card-registration .select-input.form-control[readonly]:not([disabled]) {
        font-size: 1rem;
        line-height: 2.15;
        padding-left: .75em;
        padding-right: .75em;
    }

    .card-registration .select-arrow {
        top: 13px;
    }

    .bg-grey {
        background-color: #eae8e8;
    }

    @media (min-width: 992px) {
        .card-registration-2 .bg-grey {
            border-top-right-radius: 16px;
            border-bottom-right-radius: 16px;
        }
    }

    @media (max-width: 991px) {
        .card-registration-2 .bg-grey {
            border-bottom-left-radius: 16px;
            border-bottom-right-radius: 16px;
        }
    }
</style>

<!--<script>-->
<!--    function updateQuantity(itemId, quantity) {-->
<!--        // Get the input element-->
<!--        var inputElement = document.getElementById('quantityForm');-->
<!---->
<!--        // Get the item ID from the data-itemid attribute-->
<!--        var itemId = inputElement.getAttribute('data-itemid');-->
<!---->
<!--        // Make an AJAX call to the server-->
<!--        var xhr = new XMLHttpRequest();-->
<!--        xhr.open('POST', 'localhost/festival/history/shoppingcart?controller=HistoryController&action=updateQuantity');-->
<!--        // xhr.open('POST', 'shoppingCart.php?controller=HistoryController&action=updateQuantity');-->
<!--        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');-->
<!--        xhr.onload = function () {-->
<!--            if (xhr.status === 200) {-->
<!--                console.log('Quantity updated successfully!');-->
<!--            } else {-->
<!--                console.log('Error updating quantity!');-->
<!--            }-->
<!--        };-->
<!--        xhr.send('orderItemId=' + itemId + '&quantity=' + quantity);-->
<!--    }-->
<!---->
<!--</script>-->



<!--<script>-->
<!--    function updateQuantity(itemId, quantity) {-->
<!--        console.log(itemId);-->
<!--        console.log(quantity);-->
<!--        // Make an AJAX call to the server-->
<!--        var xhr = new XMLHttpRequest();-->
<!--        xhr.open('POST', 'http://localhost/festival/history/updateQuantity');-->
<!--        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');-->
<!--        xhr.onload = function() {-->
<!--            if (xhr.status === 200) {-->
<!--                console.log('Quantity updated successfully!');-->
<!--            }-->
<!--            else {-->
<!--                console.log('Error updating quantity!');-->
<!--            }-->
<!--        };-->
<!--        xhr.send('orderItemId=' + itemId + '&quantity=' + quantity);-->
<!--    }-->
<!--</script>-->

<!--<script>-->
<!--    function updateQuantity(itemId, quantity) {-->
<!--        console.log(itemId);-->
<!--        console.log(quantity);-->
<!--        // Make an AJAX call to the server-->
<!--        var xhr = new XMLHttpRequest();-->
<!--        xhr.open('POST', 'http://localhost/festival/history/updateQuantity');-->
<!--        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');-->
<!--        xhr.onload = function() {-->
<!--            if (xhr.status === 200) {-->
<!--                console.log('Quantity updated successfully!');-->
<!--                // Update the quantity value in the input field-->
<!--                var quantityInput = document.getElementById('quantityForm' + itemId);-->
<!--                quantityInput.value = quantity;-->
<!--            }-->
<!--            else {-->
<!--                console.log('Error updating quantity!');-->
<!--            }-->
<!--        };-->
<!--        xhr.send('orderItemId=' + itemId + '&quantity=' + quantity);-->
<!--    }-->
<!--</script>-->

<!--<script>-->
<!--    function updateQuantity(itemId, quantity) {-->
<!--        console.log(itemId);-->
<!--        console.log(quantity);-->
<!---->
<!--        // Make sure the quantity is not less than zero-->
<!--        if (quantity < 0) {-->
<!--            quantity = 0;-->
<!--        }-->
<!---->
<!--        // Make an AJAX call to the server-->
<!--        var xhr = new XMLHttpRequest();-->
<!--        xhr.open('POST', 'http://localhost/festival/history/updateQuantity');-->
<!--        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');-->
<!--        xhr.onload = function() {-->
<!--            if (xhr.status === 200) {-->
<!--                console.log('Quantity updated successfully!');-->
<!--                // Update the quantity value in the input field-->
<!--                var quantityInput = document.getElementById('quantityForm' + itemId);-->
<!--                quantityInput.value = quantity;-->
<!--            }-->
<!--            else {-->
<!--                console.log('Error updating quantity!');-->
<!--            }-->
<!--        };-->
<!--        xhr.send('orderItemId=' + itemId + '&quantity=' + quantity);-->
<!--    }-->
<!--</script>-->

<script>
    function updateQuantity(itemId, quantity) {
        console.log(quantity);

        // Make sure the quantity is not less than zero
        if (quantity < 0) {
            quantity = 0;
        }

        // Check if the new quantity is zero
        if (quantity === 0) {
            // Send a request to delete the item from the shopping cart
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'http://localhost/festival/history/deleteOrderItem');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    console.log('Item deleted successfully!');
                    // Remove the item from the DOM
                    var itemContainer = document.getElementById('orderItemContainer' + itemId);
                    console.log(itemId);
                    console.log(itemContainer);
                    itemContainer.parentNode.removeChild(itemContainer);
                }
                else {
                    console.log('Error deleting item!');
                }
            };
            xhr.send('orderItemId=' + itemId);
        }
        else {
            // Send a request to update the quantity of the item in the shopping cart
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'http://localhost/festival/history/updateQuantity');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    console.log('Quantity updated successfully!');
                    // Update the quantity value in the input field
                    var quantityInput = document.getElementById('quantityForm' + itemId);
                    quantityInput.value = quantity;
                }
                else {
                    console.log('Error updating quantity!');
                }
            };
            xhr.send('orderItemId=' + itemId + '&quantity=' + quantity);
        }
    }

</script>

