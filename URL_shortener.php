<?php

include 'DBConnect.php';

//Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // URL to the Unelma.IO API
    $url = 'https://unelma.io/api/v1/link';
}
