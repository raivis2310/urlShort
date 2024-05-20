<?php

$longUrl = readline("Please enter the long URL: ");

function getShortUrl($longUrl)
{
    $apiUrl = "https://cleanuri.com/api/v1/shorten";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['url' => $longUrl]));

    $response = curl_exec($ch);

    if ($response === false) {
        $error = curl_error($ch);
        curl_close($ch);
        return "Error: $error";
    }

    curl_close($ch);

    $data = json_decode($response, true);

    if (isset($data['result_url'])) {
        return $data['result_url'];
    } else {
        return "Error: Unable to shorten the URL.";
    }
}

$shortUrl = getShortUrl($longUrl);

echo "Short URL: " . $shortUrl . "\n";