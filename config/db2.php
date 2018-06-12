<?php
// date base connection
$servername = "localhost";
$username = "login";
$password = "yes";
$dbname = "mayur";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
