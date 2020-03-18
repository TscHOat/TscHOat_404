<?php

$curl = curl_init();

try {
    // lat = long
    $Lat = $_GET['Lat'];
    $Long = $_GET['Long'];
    $Rad = $_GET['Rad'];
    // request data to overpass-api
    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://overpass-api.de/api/interpreter?data=%5Bout%3Acsv%28%3A%3Aid%29%5D%5Btimeout%3A25%5D%3B%0A%28%0A%20%20way%0A%20%20%20%20%5B%22building%22%5D%28around%3A"
            . $Rad . "%2C" . $Lat . "%2C" . $Long  .
            "%29%3B%0A%29%3B%0Aout%20body%3B",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache"
        ),
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);
    // provessing data from overpass
    $response = str_replace("@id\n", "", $response);
    $building = explode("\n", $response);
    // return data
    echo json_encode(array("return" => sizeof($building)));
} catch (Exception $e) {
    echo "error";
}



// clossing curl
curl_close($curl);
