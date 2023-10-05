<?php


$title = "Add Product";
include "layouts/header.php";
include "layouts/navbarAdmin.php";
include "App/Http/Middlewares/Auth.php";

use App\Http\Requests\Validation;
use App\Database\Models\Product;


$validation = new Validation;

if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST) {

    $validation->setOldValues($_POST);

    $validation->setInputValue($_POST['name'] ?? "")->setInputValueName('name')->required();

    $validation->setInputValue($_POST['price'] ?? "")->setInputValueName('price')->required();

    $validation->setInputValue($_POST['quantity'] ?? "")->setInputValueName('quantity')->required();

    $validation->setInputValue($_POST['product_code'] ?? "")->setInputValueName('product_code')->required()->unique("Products", "product_code");

    $validation->setInputValue($_POST['details'] ?? "")->setInputValueName('details')->required();

    $validation->setInputValue($_POST['category'] ?? "")->setInputValueName('category')->required();

    $validation->setInputValue($_POST['subcategory'] ?? "")->setInputValueName('subcategory')->required();

    $validation->setInputValue($_FILES['image']['name'] ?? "")->setInputValueName('image')->required();

    if (empty($validation->getErrors())) {

        $product = new Product;


        $product->setName($_POST['name'])
            ->setPrice($_POST['price'])
            ->setQuantity($_POST['quantity'])
            ->setProduct_code($_POST['product_code'])
            ->setDetails($_POST['details'])
            ->setStatus(1)
            ->setCategory_id($_POST['category'])
            ->setSubcategory_id($_POST['subcategory']);

        if (!empty($_FILES['image']['name'])) {
            $imageName = $_FILES['image']['name']; // Get the name of the uploaded image
            $imagePath = 'assets/img/AdminUploads/' . $imageName;
            move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
            $product->setImage($imageName); // Save only the image name to the user object
        }

        if ($product->create()) {
            $success = "<div class='alert alert-success text-center'> Product is added successfully.</div>";
            header('refresh:3;url=Products.php');
        } else {
            $error = "<div class='alert alert-danger' > Something went wrong </div>";
        }
    }
}

?>

<div class="addproductcontent">
    <div class="outerframe">
        <?= $error ?? "" ?>
        <?= $success ?? "" ?>
        <br>
        <h1>Add Product</h1>
        <form method="post" enctype="multipart/form-data">
            <?php
            if (isset($_POST['image'])) {
                $image = $_POST['image'];
            } else {
                $image = 'addphoto.png';
            }
            ?>
            <div class="mb-3">
                <label for="name" class="form-label">Procut Name*</label>
                <input name="name" type="text" class="form-control" id="name" aria-describedby="emailHelp" value="<?= $validation->getOldValue('name') ?>">
                <?= $validation->getMessage('name') ?>
            </div>
            <div class=" mb-3">
                <label for="price" class="form-label">Product Price*</label>
                <input name="price" type="text" class="form-control" id="price" value="<?= $validation->getOldValue('price') ?>">
                <?= $validation->getMessage('price') ?>
            </div>
            <div class=" mb-3">
                <label for="quantity" class="form-label">Quantity*</label>
                <input type="number" name="quantity" type="text" class="form-control" id="quantity" value="<?= $validation->getOldValue('quantity') ?>">
                <?= $validation->getMessage('quantity') ?>
            </div>
            <div class=" mb-3">
                <label for="product_code" class="form-label">Product Code*</label>
                <input name="product_code" type="text" class="form-control" id="product_code" value="<?= $validation->getOldValue('product_code') ?>">
                <?= $validation->getMessage('product_code') ?>
            </div>
            <div class=" mb-3">
                <label for="details" class="form-label">Details*</label>
                <input name="details" type="text" class="form-control" id="details" value="<?= $validation->getOldValue('details') ?>">
                <?= $validation->getMessage('details') ?>
            </div>
            <br>
            <div class="mb-3">
                <label for="category" class="form-label">Category*</label>
                <select id="categorySelect" name="category" class="form-control my-2">
                    <option value="" disabled selected hidden>Select the category of the product..</option>
                    <option <?= $validation->getOldValue('category') == '1' ? 'selected' : '' ?> value="1">Dog</option>
                    <option <?= $validation->getOldValue('category') == '2' ? 'selected' : '' ?> value="2">Cat</option>
                    <option <?= $validation->getOldValue('category') == '3' ? 'selected' : '' ?> value="3">Bird</option>
                    <option <?= $validation->getOldValue('category') == '4' ? 'selected' : '' ?> value="4">Hamster</option>
                    <option <?= $validation->getOldValue('category') == '5' ? 'selected' : '' ?> value="5">Turtle</option>
                </select>
                <?= $validation->getMessage('category') ?>
            </div>
            <br>
            <div class="mb-3">
                <label for="subcategory" class="form-label">SubCategory*</label>

                <select id="subcategorySelect" name="subcategory" class="form-control my-2">
                    <option value="" disabled selected hidden>Select the subcategory of the product..</option>
                </select>
                <?= $validation->getMessage('subcategory') ?>
            </div>
            <br><br>
            <div class=" mb-3">
                <label for="file" class="form-label">Upload Product Image** <br><br>

                    <img style="cursor:pointer; border-radius: 50%; width: 189px; height: 180px; border: solid white 5px;" id="image" src="assets/img/AdminUploads/<?= $image ?>" alt="">

                </label>
                <input type="file" name="image" id="file" onchange="loadFile(event)" value="<?= isset($_FILES['image']['name']) ? $_FILES['image']['name'] : $image  ?> ">
                <?= $validation->getMessage('image') ?>
            </div>
            <button type="submit" name="add-image" class="btn btn-primary btn-lg">Add</button>
            <button class="btn btn-primary btn-lg"><a href="Products.php">Cancel</a></button>


        </form>
    </div>
</div>

<?php
$subcategoryValue = $validation->getOldValue('subcategory');
?>


<script>
    var loadFile = function(event) {
        var output = document.getElementById('image');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src) // free memory
        }
    };

    document.getElementById('categorySelect').addEventListener('change', function() {
        const selectedCategoryId = this.value;
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'get_subcategories.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            console.log('readyState:', xhr.readyState);
            console.log('status:', xhr.status);
            console.log('responseText:', xhr.responseText);
            if (xhr.readyState === 4 && xhr.status === 200) {
                const subcategories = JSON.parse(xhr.responseText);
                console.log('subcategories:', subcategories);
                const subcategorySelect = document.getElementById('subcategorySelect');
                subcategorySelect.innerHTML = ''; // Clear existing options

                const option = document.createElement('option');
                option.value = "";
                option.textContent = "Select the subcategory of the product..";
                option.selected = true;
                option.disabled = true;
                option.hidden = true;
                subcategorySelect.appendChild(option);

                const subcategoryValue = <?php echo json_encode($subcategoryValue); ?>;

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
    });
</script>
</body>

</html>