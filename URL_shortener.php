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

    //check for cURL errors
    if (curl_errno($ch)) {
        echo 'cURL Error:' . curl_error($ch);
    } else {
        // Decode the response
        $responseDecoded = json_decode($response, true);

        //Check if the response is valid and contains link and short_url
        if ($responseDecoded !== null && isset($responseDecoded['link']) && isset($responseDecoded['link']['short_url'])) {
            // Output the shortened URL
            echo 'Shortened URL: <a href="' . $responseDecoded['link']['short_url'] . '">' . $responseDecoded['link']['short_url'] . '</a>';

            //Save the shortened URL to the database
            $db = new DBConnect();
            $conn = $db->connect(); // Establish database connection
            if ($conn) { // Check if connection is successful
                $stmt = $conn->prepare("INSERT INTO shortenedurls (long_url, short_url) VALUES (?, ?)");
                $stmt->execute([$longUrl, $responseDecoded['link']['short_url']]);
                echo "URL successfully saved to database.";
            } else {
                echo "Failed to connect to the database.";
            }
        } else {
            //Handle the case where the response does not contain link or short-url
            echo 'Error: Unable to shorten the URL. Response body: ';
            // Debugging: Print out the response for further investigation
            var_dump($response);
        }
    }
    
    // Close cURL session
    curl_close($ch);
}
?>
            
        
<!DOCTYPE html>
<html>
<head>
    <title>URL Shortener</title>
</head>
<body>
    <form method="POST" action="">
        <label for="longUrl">Enter URL to shorten:</label><br>
        <input type="text" id="longUrl" name="longUrl"><br><br>
        <input type="submit" value="Shorten URL">
    </form>
</body>
</html>
