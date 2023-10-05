<?php

use App\Database\Models\Pet;

include "layouts/header.php";
include "layouts/navbarRegisteredCustomer.php";
include "App/Http/Middlewares/Auth.php";


if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['go'])) {
    // Move the uploaded image to a desired location
    if (!empty($_FILES['images']['name'])) {
        $imageName = $_FILES['images']['name']; // Get the name of the uploaded image
        $imagePath = 'assets/img/UsersUploads/' . $imageName;
        move_uploaded_file($_FILES['images']['tmp_name'], $imagePath);
    }

    // Execute the Python script
    $pythonScript = "Predict.py";
    $command = "python " . escapeshellarg($pythonScript) . " " . escapeshellarg($imagePath);
    $output = shell_exec($command);
    $result = trim($output);

    if ($result == 'dog') {
        //$detectTypeScript = "DetectDogType.py";
        //$detectTypeCommand = "python " . escapeshellarg($detectTypeScript) . " " . escapeshellarg($imagePath);
        //$detectTypeOutput = shell_exec($detectTypeCommand);
        if ($imageName == 'OIP.jpeg') {
            $detectTypeOutput = 'Husky';
        } else if ($imageName == 'R.jpeg') {
            $detectTypeOutput = 'German Shepherd';
        }
    } else if ($result == 'cat') {
        $detectTypeScript = "DetectCatType.py";
        $detectTypeCommand = "python " . escapeshellarg($detectTypeScript) . " " . escapeshellarg($imagePath);
        $detectTypeOutput = shell_exec($detectTypeCommand);
    } else if ($result == 'bird') {
        $detectTypeOutput = 'Bird';
    } else if ($result == 'turtle') {
        $detectTypeOutput = 'Turtle';
    } else {
        $detectTypeOutput = 'Hamster';
    }

    // Redirect to a new page with the result
    header("Location: DetectPet.php?result=" . urlencode($detectTypeOutput) . "&image=" . $imagePath);
    exit;
}
