<?php

function curl($url)
{
    $ch = curl_init();

    // set URL
    curl_setopt($ch, CURLOPT_URL, $url);
    // return as a string
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $hasil = curl_exec($ch);

    curl_close($ch);
    return $hasil;
}
