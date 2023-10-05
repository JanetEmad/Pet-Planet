<?php

$title = "Shopping Cart";
include "layouts/header.php";
if (isset($_SESSION['user'])) {
    if ($_SESSION['user']->service_provider_status == 0) {
        include "layouts/navbarRegisteredCustomer.php";
    } else {
        include "layouts/navbarRegisteredSP.php";
    }
} else {
    include "layouts/navbar.php";
}
include "App/Http/Middlewares/Auth.php";

use App\Database\Models\Product;
use App\Database\Models\Cart;
use App\Database\Models\Fav;



$productObj = new Product;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id_rm'])) {

    $cart = new Cart;
    $cart->setUser_id($_SESSION['user']->id)->setProduct_id($_POST['product_id_rm']);
    $cart->delete();

    // Redirect back to the same page or any other appropriate location
    header("Location: ShoppingCart.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_quantity'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    $cart = new Cart;
    $cart->setUser_id($_SESSION['user']->id)->setProduct_id($_POST['product_id'])->setQuantity_needed($quantity);
    $cart->update();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        switch ($action) {
            case 'add_to_wishlist':

                $fav = new Fav;

                $fav
                    ->setUser_id($_SESSION['user']->id)
                    ->setProduct_id($_POST['product_id_sfl']);

                if ($fav->checkUnique()) {
                    // $error = "<div class='alert alert-danger' > Product is already in your wishlist </div>";
                } else {
                    if ($fav->create()) {
                        $success = "<div class='alert alert-success text-center'>Product is added successfully to the wishlist.</div>";
                        header('refresh:3');
                    } else {
                        $error = "<div class='alert alert-danger' > Something went wrong </div>";
                    }
                }
                $cart = new Cart;
                $cart->setUser_id($_SESSION['user']->id)->setProduct_id($_POST['product_id_sfl']);
                $cart->delete();
                break;

            default:
                // Handle unknown action
                break;
        }
    }
}
?>
<br>

<div class="cartcontent">
    <div class="row">
        <div class="storeimage">
            <img src="assets/img/YImages/store.png">
        </div>
    </div>


    <?= isset($success) ? $success : "" ?>
    <?= isset($error) ? $error : "" ?>
    <div class="cartbox">
        <div class="row">

            <h1>Shopping Cart</h1>

            <?php
            $totalPrice = 0;
            $cartObj = new Cart;
            $cartObj->setUser_id($_SESSION['user']->id);
            $carts = $cartObj->read();
            ?>
            <!-- without products -->
            <?php if (empty($carts)) { ?>
                <br>

                <h3 class="yet">No Products were added yet!</h3>
            <?php } else {
            ?>
                <!-- with products -->
                <?php foreach ($carts as $cart) { ?>

                    <div class="cartitem">
                        <div class="row">
                            <div class="productimg">
                                <img src="assets/img/AdminUploads/<?= $cart['image'] ?>">
                            </div>

                            <div class="productdetails">
                                <p><?= $cart['name'] ?></p>
                                <p>Price: <?= $cart['price'] . " LE" ?></p>
                                <p><?= $cart['details'] ?></p>
                                <p style="color: #62AC5D;"><?= $cart['quantity'] != 0 ? "In Stock" : "Out Of Stock" ?></p>
                                <div class="number-input">
                                    <form method="POST">
                                        <input type="hidden" name="product_id" value="<?= $cart['product_id'] ?>">
                                        <input type="hidden" name="update_quantity" value="1">
                                        <button onclick="changeQuantity(this, 'minus')" class="minus"></button>
                                        <input class="quantity" min="1" name="quantity" value="<?= $cart['quantity_needed'] ?>" type="number" data-product-id="<?= $cart['product_id'] ?>">
                                        <button onclick="changeQuantity(this, 'plus')" class="plus"></button>
                                    </form>
                                </div>
                            </div>
                            <?php
                            $totalPrice = $totalPrice + ($cart['price'] * $cart['quantity_needed']);
                            ?>

                            <div class="dropdown">
                                <span></span>
                                <button class="dropbtn"><span> <i class="ri-more-2-line"></i></span></button>
                                <div class="dropdown-content">
                                    <form class="menu-form" method="POST" action="">
                                        <input type="hidden" name="product_id_rm" value="<?php echo $cart['product_id']; ?>">
                                        <button type="submit" class="remove-from-cart-btn">Remove From Cart</button>
                                    </form>
                                    <form class="menu-form" method="POST" action="">
                                        <input type="hidden" name="product_id_sfl" value="<?php echo $cart['product_id']; ?>">
                                        <button name="action" type="submit" class="save-for-later-btn" value="add_to_wishlist">Save For Later</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
            <?php }
            }
            ?>
        </div>
        <div class="end">
            <div class="row">
                <h3>SubTotal: <?= $totalPrice . " LE" ?></h3>
            </div>

            <div class="row">
                <button><a href="Reciet.php?P=<?= $totalPrice ?>">Proceed to Buy</a></button>
                <button><a href="Store.php">Cancel</a></button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function changeQuantity(button, action, productID) {
            var input = button.parentNode.querySelector('.quantity');
            var currentValue = parseInt(input.value);

            if (action === 'plus') {
                input.value = currentValue + 1;
            } else if (action === 'minus') {
                if (currentValue > 1) {
                    input.value = currentValue - 1;
                }
            }

            // Submit the form to update the quantity on the server
            button.parentNode.submit();
        }
    </script>

    </body>

    </html>