<?php

/**
 * Check whether current url is match with given url
 *
 * @param $url
 * @param string $active
 * @param string $disactive
 * @return string
 */
function is_active($url, $active = 'active', $disactive = '')
{
    return strpos(request()->url(), $url) !== false ? $active : $disactive;
}

function child_active($url, $active = true, $disactive = false)
{
    return strpos(request()->url(), $url) !== false ? $active : $disactive;
}

function GetDrivingDistance($lat1, $lat2, $long1, $long2)
{
    $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$lat1.",".$long1."&destinations=".$lat2.",".$long2."&mode=driving&language=pl-PL";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);
    curl_close($ch);
    $response_a = json_decode($response, true);
    $dist = $response_a['rows'][0]['elements'][0]['distance']['text'];
    $time = $response_a['rows'][0]['elements'][0]['duration']['text'];

    return array('distance' => $dist, 'time' => $time);
}

function GetTSPDistance($lat, $long, $way_points)
{
    $waypoints = implode('|', $way_points);
//    dd($way_points);
    $url = "https://maps.googleapis.com/maps/api/directions/json?origin=".$lat.",".$long."&destination=".$lat.",".$long."&waypoints=optimize:true|".$waypoints."&key=AIzaSyDTp3vvNwILQR8qOSmuZvUAKlpoY5cSc18";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);
    curl_close($ch);
    $response_a = json_decode($response, true);
//    dd($response_a);
    $dist = 0;
//    dd(count($response_a['routes'][0]['legs']));
    $locations = array();
    foreach ($response_a['routes'][0]['waypoint_order'] as $key => $waypoint){
        $locations[$key] = $way_points[$waypoint];
    }
    for ($i = 0; $i < count($response_a['routes'][0]['legs']); $i++){
        $dist += $response_a['routes'][0]['legs'][$i]['distance']['text'];
    }

//    dd($locations);

    return array('locations' => $locations, 'dist' => $dist);
}