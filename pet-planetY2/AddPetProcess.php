<?php

use App\Database\Models\Pet;

include "layouts/header.php";
include "layouts/navbarRegisteredCustomer.php";
include "App/Http/Middlewares/Auth.php";


// Retrieve the form values from session variables
$formValues = $_SESSION['form_data'] ?? [];
$imagePath = $_SESSION['imagepath'];
$image = $_SESSION['image'];

unset($_SESSION['form_data']);
unset($_SESSION['imagepath']);
unset($_SESSION['image']);


// Execute the Python script
$pythonScript = "Predict.py";
$command = "python " . escapeshellarg($pythonScript) . " " . escapeshellarg($imagePath);
$output = shell_exec($command);
$result = trim($output);

if ($formValues['family'] == 1) {
    $type = 'dog';
} else if ($formValues['family'] == 2) {
    $type = 'cat';
} else if ($formValues['family'] == 3) {
    $type = 'bird';
} else if ($formValues['family'] == 4) {
    $type = 'hamster';
} else {
    $type = 'turtle';
}

if ($result == $type) {
    $pet = new Pet;

    $pet->setName($formValues['name'])
        ->setType($formValues['type'])
        ->setFamily($formValues['family'])
        ->setAge($formValues['age'])
        ->setGender($formValues['gender'])
        ->setUser_id($_SESSION['user']->id)
        ->setCategory_id($formValues['family'])
        ->setPending(0);

    if (!empty($image)) {
        $pet->setImage($image); // Save only the image name to the pet object
    } else {
        // No new image provided, use the existing image name
        $pet->setImage('petdefault.webp');
    }

    if ($pet->create()) {
        $databaseResult = $pet->setImage($image)->getPetInfo();
        $databasePet = $databaseResult->fetch_object();
        $_SESSION['pet'] = $databasePet;
        header("Location: AddPet.php?result=1");
        exit;
    } else {
        header("Location: AddPet.php?result=0");
        exit;
    }
} else {
    header("Location: AddPet.php?result=0");
    exit;
}
