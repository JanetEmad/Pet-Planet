<?php


$title = "Admin Store";
include "layouts/header.php";
include "layouts/navbarAdmin.php";
include "App/Http/Middlewares/Auth.php";

use App\Database\Models\Product;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id_rm'])) {

    $product = new Product;
    $product->setId($_POST['product_id_rm']);
    $product->delete();

    // Redirect back to the same page or any other appropriate location
    header("Location: Products.php");
    exit();
}
?>
<div class="productscontent">

    <h1>Products</h1>

    <a class="addproduct" href="AddProduct.php">
        <button>+ Add New Product</button>
    </a>
    <!-- <div class="search">
        <input type="text" class="searchTerm" placeholder="Search for Product...">
        <button type="submit" class="searchButton">
            <i class="ri-search-line"></i>
        </button>
    </div> -->

    <div class="productslist">

        <?php
        $productObj = new Product;
        $products = $productObj->readForAdmin();
        foreach ($products as $product) {
        ?>
            <div class="product">
                <div class="oneproduct">
                    <div class="productimg">
                        <img src="assets/img/AdminUploads/<?= $product['image'] ?>">
                    </div>
                    <div class="productabout">
                        <p><?= $product['name'] ?></p>
                        <p><?= $product['details'] ?></p>
                        <p><?= $product['price'] . " LE" ?></p>
                    </div>
                </div>
                <div class="buttons">
                    <a href="UpdateProduct.php?id=<?= $product['id'] ?>">
                        <button>Edit</button>
                    </a>
                    <a href="#">
                        <form class="menu-form" method="POST" action="">
                            <input type="hidden" name="product_id_rm" value="<?php echo $product['id']; ?>">

                            <button type="submit" class="delete-product-btn">Delete</button>
                        </form>
                    </a>
                </div>

            </div>
            <br>
            <hr>
        <?php
        }
        ?>


    </div>


    </body>

    </html>