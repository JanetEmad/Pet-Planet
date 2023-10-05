<?php

$title = "Store";
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

use App\Database\Models\Category;
use App\Database\Models\Subcategory;
use App\Database\Models\Product;
use App\Database\Models\Fav;
use App\Database\Models\Cart;


$categoryObject = new Category;
$subcategoryObject = new Subcategory;
$productObj = new Product;

$categories = $categoryObject->read();

$quantityN = 0;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        switch ($action) {
            case 'add_to_cart':

                $cart = new Cart;

                $cart->setUser_id($_SESSION['user']->id)
                    ->setProduct_id($_POST['product_id']);



                if ($cart->checkUnique()) {

                    $quantityN = $cart->get();
                    $cart->setUser_id($_SESSION['user']->id)
                        ->setProduct_id($_POST['product_id'])
                        ->setQuantity_needed($quantityN + 1);

                    if ($cart->update()) {
                        $success = "<div class='alert alert-success text-center'>Product is added successfully to the cart.</div>";
                        header('refresh:3');
                    } else {
                        $error = "<div class='alert alert-danger' > Something went wrong </div>";
                    }
                } else {
                    $cart->setUser_id($_SESSION['user']->id)
                        ->setProduct_id($_POST['product_id'])
                        ->setQuantity_needed(1);

                    if ($cart->create()) {
                        $success = "<div class='alert alert-success text-center'>Product is added successfully to the cart.</div>";
                        header('refresh:3');
                    } else {
                        $error = "<div class='alert alert-danger' > Something went wrong </div>";
                    }
                }
                break;

            case 'add_to_wishlist':

                $fav = new Fav;

                $fav
                    ->setUser_id($_SESSION['user']->id)
                    ->setProduct_id($_POST['product_id']);

                if ($fav->checkUnique()) {
                    $error = "<div class='alert alert-danger' > Product is already in your wishlist </div>";
                } else {
                    if ($fav->create()) {
                        $success = "<div class='alert alert-success text-center'>Product is added successfully to the wishlist.</div>";
                        header('refresh:3');
                    } else {
                        $error = "<div class='alert alert-danger' > Something went wrong </div>";
                    }
                }

                break;

            default:
                // Handle unknown action
                break;
        }
    }
}


if ($_GET) {
    if (isset($_GET['sub'])) {

        if (is_numeric($_GET['sub'])) {
            $subcategoryObject->setCategory_id($_GET['cat']);
            $subcategories = $subcategoryObject->getSubByCat();

            $productObj->setSubcategory_id($_GET['sub']);
            $products = $productObj->getProductsBySub()->fetch_all(MYSQLI_ASSOC);
        } else {
            $subcategories = $subcategoryObject->getSub();

            $products = $productObj->getProductsBySubName($_GET['sub'])->fetch_all(MYSQLI_ASSOC);
        }
    } elseif (isset($_GET['cat'])) {
        $productObj->setCategory_id($_GET['cat']);
        $products = $productObj->getProductsByCat()->fetch_all(MYSQLI_ASSOC);

        $subcategoryObject->setCategory_id($_GET['cat']);
        $subcategories = $subcategoryObject->getSubByCat();
    } elseif (isset($_GET['cat']) && isset($_GET['sub'])) {
        $subcategoryObject->setCategory_id($_GET['cat']);
        $subcategories = $subcategoryObject->getSubByCat();
        $products = $productObj->getProductsBySub()->fetch_all(MYSQLI_ASSOC);
    } else {
        $subcategories = $subcategoryObject->getSub();
        $products = $productObj->read();
    }
} else {
    unset($_SESSION['selected_image']);
    $subcategories = $subcategoryObject->getSub();
    $products = $productObj->read();
}


?>


<div class="storecontent">
    <div class="row">
        <div class="storeimage">
            <img src="assets/img/YImages/store.png">
        </div>
    </div>


    <div class="categories">
        <div class="row">
            <?php
            $selectedImage = null;
            if (isset($_SESSION['selected_image'])) {
                $selectedImage = $_SESSION['selected_image'];
            }

            foreach ($categories as $category) {
            ?>
                <div class="col-xs-2">
                    <a href="Store.php?cat=<?= $category['id'] ?>" onclick="changeImage(this)">

                        <div class="category" tabindex="<?= $category['id'] ?>">
                            <?php
                            $imageName2 = $category['image'];


                            $path_parts = pathinfo($imageName2);
                            if ($selectedImage != null && strpos($selectedImage, $path_parts['filename']) !== false) {
                                // Check if the image is selected

                                $imageName2 = $selectedImage;
                            }
                            ?>
                            <img src="assets/img/YImages/<?= $imageName2 ?>">
                        </div>
                    </a>
                </div>


            <?php } ?>
            <div class="dropdown">
                <button class="dropbtn">Filter</button>
                <div class="dropdown-content">
                    <?php foreach ($subcategories as $subcategory) { ?>
                        <a href="Store.php?cat=<?= isset($_GET['cat']) ? $_GET['cat'] : "" ?>&sub=<?= isset($subcategory['id']) ? $subcategory['id'] : $subcategory['name'] ?>"><?= $subcategory['name'] ?></a>
                    <?php } ?>
                </div>
            </div>

        </div>
    </div>




    <div class="products">
        <?= isset($success) ? $success : "" ?>
        <?= isset($error) ? $error : "" ?>

        <div class="row">

            <?php foreach ($products as $product) { ?>
                <div class="col-xl-4">
                    <form method="POST" action="">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <input type="hidden" name="quantity" value="1">

                        <div class="product">
                            <p><?= $product['name'] ?></p>
                            <p>price: <?= $product['price'] . "LE" ?></p>
                            <img alt="" src="assets/img/AdminUploads/<?= $product['image'] ?>"><br><br>
                            <p style="line-height: 30px;"><?= $product['details'] ?></p>

                            <div class="cart">
                                <a href="#">
                                    <span><i class="ri-shopping-cart-2-line"></i></span>
                                    <button name="action" style="border: none; background: white; font-size: 26px; color: #707070; margin-bottom: 12px;" value="add_to_cart" type="submit">Add to Cart</button>
                                </a>
                            </div>
                            <div class="wishlist">
                                <a href="#">
                                    <span><i class="ri-heart-line"></i></span>
                                    <button name="action" style="border: none; background: white; font-size: 26px; color: #707070; margin-bottom: 12px;" value="add_to_wishlist" type="submit">Add to Wishlist</button>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            <?php } ?>

        </div>
    </div>

    <div class="footer">
        <div class="row">

            <div class="cart">
                <a href="ShoppingCart.php">
                    <span><i class="ri-shopping-cart-2-line"></i></span>
                    <h3>Go To Cart</h3>
                </a>
            </div>

            <div class="love">
                <a href="Wishlist.php">
                    <span><i class="ri-heart-line"></i></span>
                    <h3>Go To wishlist</h3>
                </a>
            </div>
        </div>
    </div>





</div>


<script>
    var selectedImage = null;

    function changeImage(clickedElement) {
        var clickedImage = clickedElement.querySelector("img");
        if (selectedImage) {
            selectedImage.src = selectedImage.src.replace("-choosed", ""); // Remove "-choosed" from the previous selected image
        }
        clickedImage.src = clickedImage.src.replace(/\.[^/.]+$/, "-choosed$&"); // Add "-choosed" to the clicked image
        selectedImage = clickedImage; // Update the selected image

        // Store the selected image in the session using AJAX
        var imageName = clickedImage.src.substring(clickedImage.src.lastIndexOf("/") + 1);
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "store_ajax.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                console.log("Image saved to session successfully");
            }
        };
        xhr.send("selected_image=" + encodeURIComponent(imageName));
    }
</script>
</body>

</html>