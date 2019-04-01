<?php

// header("content-type: text/plain");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: "origin, x-requested-with, content-type"');
header('Access-Control-Allow-Methods "GET, POST, OPTIONS"');
// header('Content-Type', 'application/x-www-form-urlencoded');

$servername = '';
$username = '';
$password = '';
$dbname = '';
//connect.php stores 4 variable names. 
include "connect.php"; 

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// need to select & prepare data for the options dropdown on hostPage.html
if (isset($_GET["createEvent"])) {
    $event = $_GET["createEvent"];
}
    // echo $event; 
    $stmt = $conn->prepare("SELECT createEvent FROM events"); 
    $stmt -> execute(['$event']);
    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
    $tableRow = $stmt -> fetchAll(); 

    $myJSON = json_encode($tableRow);
    
    echo $myJSON;

// foreach ($tableRow as $t) {
//     echo $t<option id="createEvent" value=""></option>; 
   

?>