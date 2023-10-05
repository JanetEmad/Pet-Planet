<?php
require "vendor/autoload.php";

use App\Database\Models\Subcategory;


// Include necessary files and initialize database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['category_id'])) {


    $subcategoryObj = new Subcategory;
    $subcategoryObj->setCategory_id($_POST['category_id']);
    $subcategories = $subcategoryObj->getSubByCat();


    $responseText = [];
    foreach ($subcategories as $subcategory) {
        $responseText[] = [
            'id' => $subcategory['id'],
            'name' => $subcategory['name']
        ];
    }

    // Send the response as JSON
    header('Content-Type: application/json');
    echo json_encode($responseText);

    exit;
}
