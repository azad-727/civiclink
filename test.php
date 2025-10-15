<?php
// Allow requests from any origin (for development)
header("Access-Control-Allow-Origin: *");
// Set the content type to JSON
header("Content-Type: application/json; charset=UTF-8");

// Create a simple associative array
$response = [
    "status" => "success",
    "message" => "Hello from the CivicLink PHP Backend!"
];

// Encode the array into a JSON string and echo it
echo json_encode($response);
?>