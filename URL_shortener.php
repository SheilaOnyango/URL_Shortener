<?php

include 'DBConnect.php';

//Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // URL to the Unelma.IO API
    $url = 'https://unelma.io/api/v1/link';

    //Access token for the Unelma.IO API
    $accessToken = '27|ht0AeOmils4W1NtNtTs3bLmJ45mpJp9LVxuzguSe9ae0dd33';
    
    // Collect the long URL from the form input
    $longUrl = $_POST['longUrl'];
    
    //Prepare the data to be sent to the post request
    $data = [
        "type" => "direct",
        "password" => null,
        "active" => true,
        "expires_at" => "2024-06-25",
        "activates_at" => "2024-03-25",
        "utm" => "utm_source=google&utm_medium=banner",
        "domain_id" => null,
        "long_url" => $longUrl
    ];

    //Initialize cURL session
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'accept: application/json',
        'Content-Type: application/json',
        'Authorization: Bearer ' . $accessToken,
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    
    // Execute the POST request
    $response = curl_exec($ch);
}
