<?php
if (isset($_POST['lat']) && isset($_POST['long'])) {
    $lat = $_POST['lat'];
    $long = $_POST['long'];

    // API endpoint and key
    $apiKey = "00Fym3GhTRmEXjth4EMBSuDeUbLjnqG8";
    $url = "http://www.mapquestapi.com/geocoding/v1/reverse?key={$apiKey}&location={$lat},{$long}";

    // Send a GET request to the MapQuest Geocoding API
    $response = file_get_contents($url);

    // Parse the JSON response
    $data = json_decode($response, true);

    // Check if the request was successful
    if ($data['info']['statuscode'] === 0) {
        // Retrieve all the address information
        $addressData = $data['results'][0]['locations'][0];

        // Construct the address as a text string
        $address = '';
        if (!empty($addressData['street'])) {
            $address .= $addressData['street'] . ', ';
        }
        if (!empty($addressData['adminArea6'])) {
            $address .= $addressData['adminArea6'] . ', ';
        }
        if (!empty($addressData['adminArea5'])) {
            $address .= $addressData['adminArea5'] . ', ';
        }
        if (!empty($addressData['adminArea4'])) {
            $address .= $addressData['adminArea4'] . ', ';
        }
        if (!empty($addressData['adminArea3'])) {
            $address .= $addressData['adminArea3'] . ', ';
        }
        if (!empty($addressData['adminArea1'])) {
            $address .= $addressData['adminArea1'];
        }

        // Return the address as plain text
        header('Content-Type: application/json');
        echo json_encode($address);
    } else {
        // Return an error message
        echo "Address not found";
    }
} else {
    // Return an error message
    echo "Invalid parameters";
}
