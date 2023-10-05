<?php

$title = "Wishlist";

use App\Database\Models\Product;
use App\Database\Models\Fav;
use App\Database\Models\Cart;


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

$productObj = new Product;


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id_rm'])) {

    $fav = new Fav;
    $fav->setUser_id($_SESSION['user']->id)->setProduct_id($_POST['product_id_rm']);
    $fav->delete();

    // Redirect back to the same page or any other appropriate location
    header("Location: Wishlist.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        switch ($action) {
            case 'add_to_cart':

                $cart = new Cart;

                $cart->setUser_id($_SESSION['user']->id)
                    ->setProduct_id($_POST['product_id_atc']);


                if ($cart->checkUnique()) {

                    $quantityN = $cart->get();
                    $cart->setUser_id($_SESSION['user']->id)
                        ->setProduct_id($_POST['product_id_atc'])
                        ->setQuantity_needed($quantityN + 1);

                    if ($cart->update()) {
                        $success = "<div class='alert alert-success text-center'>Product is added successfully to the cart.</div>";
                        header('refresh:3');
                    } else {
                        $error = "<div class='alert alert-danger' > Something went wrong </div>";
                    }
                } else {

                    $cart->setUser_id($_SESSION['user']->id)
                        ->setProduct_id($_POST['product_id_atc'])
                        ->setQuantity_needed(1);

                    if ($cart->create()) {
                        $success = "<div class='alert alert-success text-center'>Product is added successfully to the cart.</div>";
                        header('refresh:3');
                    } else {
                        $error = "<div class='alert alert-danger' > Something went wrong </div>";
                    }
                }
                $fav = new Fav;
                $fav->setUser_id($_SESSION['user']->id)->setProduct_id($_POST['product_id_atc']);
                $fav->delete();

                break;

            default:
                // Handle unknown action
                break;
        }
    }
}
?>


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

            <h1>Wishlist</h1>
            <?php
            $favObj = new Fav;
            $favObj->setUser_id($_SESSION['user']->id);
            $wishlists = $favObj->read();
            ?>
            <!-- without products -->
            <?php if (empty($wishlists)) { ?>
                <br>

                <h3 class="yet">No Products were added yet!</h3>
            <?php } else {
            ?>
                <!-- with products -->
                <?php foreach ($wishlists as $wishlist) { ?>

                    <div class="cartitem">
                        <div class="row">
                            <div class="productimg">
                                <img src="assets/img/AdminUploads/<?= $wishlist['image'] ?>">
                            </div>

                            <div class="productdetails">
                                <p><?= $wishlist['name'] ?></p>
                                <p>Price: <?= $wishlist['price'] . " LE" ?></p>
                                <p><?= $wishlist['details'] ?></p>
                                <p style="color: #62AC5D;"><?= $wishlist['quantity'] != 0 ? "In Stock" : "Out Of Stock" ?></p>
                            </div>

                            <div class="dropdown">
                                <span></span>
                                <button class="dropbtn"><span> <i class="ri-more-2-line"></i></span></button>
                                <div class="dropdown-content">
                                    <form class="menu-form" method="POST" action="">
                                        <input type="hidden" name="product_id_rm" value="<?php echo $wishlist['product_id']; ?>">
                                        <button type="submit" class="remove-from-wishlist-btn">Remove From Wishlist</button>
                                    </form>
                                    <form class="menu-form" method="POST" action="">
                                        <input type="hidden" name="product_id_atc" value="<?php echo $wishlist['product_id']; ?>">
                                        <input type="hidden" name="quantity" value="1">
                                        <button name="action" type="submit" class="add-to-cart-btn" value="add_to_cart">Move To Cart</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
            <?php }
            } ?>
        </div>
    </div>
</div>
</body>

</html>