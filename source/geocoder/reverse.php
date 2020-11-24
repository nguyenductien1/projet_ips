<?php
function reverse_coordinate($lat, $long){

    $json = file_get_contents("https://nominatim.openstreetmap.org/reverse?format=json&lat={$lat}&lon={$long}&zoom=18&addressdetails=1");
    $obj = json_decode($json);
    return $obj->address;
}


?>