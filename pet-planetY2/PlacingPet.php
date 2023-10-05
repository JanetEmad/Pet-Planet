<?php

$title = "Placing Pet";
include "layouts/header.php";
include "layouts/navbarRegisteredCustomer.php";
include "App/Http/Middlewares/Auth.php";

use App\Database\Models\Pet;

if ($_GET && isset($_GET["adopt"])) {
    $data = $_GET["adopt"];

    $petObj = new Pet;
    $petObj->setId($data);
    $pet = $petObj;
    $pet->placePetForAdoption();
    header("location:PlacingConfirmation.php?type=Adoption");
}
if ($_GET && isset($_GET["sell"])) {
    $data = $_GET["sell"];

    $petObj = new Pet;
    $petObj->setId($data);
    $pet = $petObj;
    $pet->placePetForSelling();
    header("location:PlacingConfirmation.php?type=Selling");
}
if ($_GET && isset($_GET["mate"])) {
    $data = $_GET["mate"];

    $petObj = new Pet;
    $petObj->setId($data);
    $pet = $petObj;
    $pet->placePetForMating();
    header("location:PlacingConfirmation.php?type=Mating");
}
