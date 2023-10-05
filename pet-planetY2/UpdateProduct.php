<?php


$title = "Update Product";
include "layouts/header.php";
include "layouts/navbarAdmin.php";
include "App/Http/Middlewares/Auth.php";

use App\Http\Requests\Validation;
use App\Database\Models\Product;

if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    $product = new Product;
    $product->setId($productId);
    $productData = $product->find();
    $row = $productData->fetch_assoc();
}

$validation = new Validation;

if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST) {

    $validation->setOldValues($_POST);

    $validation->setInputValue($_POST['name'] ?? "")->setInputValueName('name')->between(2, 32);


    if (empty($validation->getErrors())) {

        $product = new Product;


        $product->setName($_POST['name'])
            ->setPrice($_POST['price'])
            ->setQuantity($_POST['quantity'])
            ->setProduct_code($_POST['product_code'])
            ->setDetails($_POST['details'])
            ->setStatus(1)
            ->setCategory_id($_POST['category'])
            ->setSubcategory_id($_POST['subcategory'])
            ->setId($row['id']);

        if (!empty($_FILES['image']['name'])) {
            $imageName = $_FILES['image']['name']; // Get the name of the uploaded image
            $imagePath = 'assets/img/AdminUploads/' . $imageName;
            move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
            $product->setImage($imageName);
        }

        if ($product->update()) {

            $success = "<div class='alert alert-success text-center'> Product is updated successfully.</div>";
            header('refresh:3;url=Products.php');
        } else {
            $error = "<div class='alert alert-danger' > Something went wrong </div>";
        }
    }
}
?>

<div class="addproductcontent">
    <div class="outerframe">
        <h1>Update Product</h1>
        <?= $error ?? "" ?>
        <?= $success ?? "" ?>
        <form method="POST" enctype="multipart/form-data">
            <?php
            if (isset($_FILES['update-image']['name'])) {
                $image = $_FILES['update-image']['name'];
            } else {
                $image = $row['image'];
            }
            ?>
            <div class="mb-3">
                <label for="name" class="form-label">Product Name</label>
                <input name="name" type="text" class="form-control" id="name" aria-describedby="emailHelp" value="<?= isset($_POST['name']) ? $_POST['name'] : $row['name'] ?>">
                <?= $validation->getMessage('name') ?>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Product Price</label>
                <input name="price" type="text" class="form-control" id="price" value="<?= isset($_POST['price']) ? $_POST['price'] : $row['price'] ?>">
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input name="quantity" type="text" class="form-control" id="quantity" value="<?= isset($_POST['quantity']) ? $_POST['quantity'] : $row['quantity'] ?>">
            </div>
            <div class="mb-3">
                <label for="product_code" class="form-label">Product Code</label>
                <input name="product_code" type="text" class="form-control" id="product_code" value="<?= isset($_POST['product_code']) ? $_POST['product_code'] : $row['product_code'] ?>">
            </div>
            <div class="mb-3">
                <label for="details" class="form-label">Details</label>
                <input name="details" type="text" class="form-control" id="details" value="<?= isset($_POST['details']) ? $_POST['details'] : $row['details'] ?>">
            </div>
            <br>

            <div class="mb-3">
                <label for="category" class="form-label">Category*</label>
                <select id="categorySelect" name="category" class="form-control my-2">
                    <option <?= isset($_POST['category']) && $_POST['category'] === '1' ? 'selected' : ($row['category_id'] == '1' ? 'selected' : '') ?> value="1">Dog</option>
                    <option <?= isset($_POST['category']) && $_POST['category'] === '2' ? 'selected' : ($row['category_id'] == '2' ? 'selected' : '') ?> value="2">Cat</option>
                    <option <?= isset($_POST['category']) && $_POST['category'] === '3' ? 'selected' : ($row['category_id'] == '3' ? 'selected' : '') ?> value="3">Bird</option>
                    <option <?= isset($_POST['category']) && $_POST['category'] === '4' ? 'selected' : ($row['category_id'] == '4' ? 'selected' : '') ?> value="4">Hamster</option>
                    <option <?= isset($_POST['category']) && $_POST['category'] === '5' ? 'selected' : ($row['category_id'] == '5' ? 'selected' : '') ?> value="5">Turtle</option>
                </select>
            </div>

            <br>
            <div class="mb-3">
                <label for="subcategory" class="form-label">SubCategory*</label>
                <select id="subcategorySelect" name="subcategory" class="form-control my-2">
                </select>
            </div>

            <br><br>
            <div class="mb-3">
                <label for="file">Upload Product Image <br><br>
                    <img style="cursor:pointer; border-radius: 50%; width: 189px; height: 180px; border: solid white 5px;" id="image" src="assets/img/AdminUploads/<?= $image ?>" alt="">
                </label>
                <input type="file" name="update-image" id="file" onchange="loadFile(event)" value="<?= $image ?> ">
            </div>
            <br><br>
            <button type="submit" class="btn btn-primary btn-lg">Update</button>
            <button type="button" class="btn btn-primary btn-lg"><a href="Products.php">Cancel</a></button>


        </form>
    </div>
</div>


<script>
    var loadFile = function(event) {
        var output = document.getElementById('image');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src) // free memory
        }
    };


    function updateSubcategorySelection() {
        const selectedCategoryId = document.getElementById('categorySelect').value;

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'get_subcategories.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const subcategories = JSON.parse(xhr.responseText);
                const subcategorySelect = document.getElementById('subcategorySelect');
                subcategorySelect.innerHTML = '';

                const option = document.createElement('option');
                option.value = "";
                option.textContent = "Select the subcategory of the product..";
                option.selected = true;
                option.disabled = true;
                option.hidden = true;
                subcategorySelect.appendChild(option);

                const subcategoryValue = <?= isset($_POST['subcategory']) ? $_POST['subcategory'] : $row['subcategory_id'] ?>;

                for (const subcategory of subcategories) {
                    const option = document.createElement('option');
                    option.value = subcategory.id;
                    option.textContent = subcategory.name;
                    option.selected = (subcategory.id === subcategoryValue);
                    subcategorySelect.appendChild(option);
                }
            }
        };
        xhr.send('category_id=' + selectedCategoryId);
    }

    document.addEventListener('DOMContentLoaded', function() {
        updateSubcategorySelection();
    });

    document.getElementById('categorySelect').addEventListener('change', function() {
        updateSubcategorySelection();
    });
</script>

</body>

</html>