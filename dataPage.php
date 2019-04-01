<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: "origin, x-requested-with, content-type"');
header('Access-Control-Allow-Methods "GET, POST, OPTIONS"');
header('Content-Type', 'application/x-www-form-urlencoded');
$servername = '';
$username = '';
$password = '';
$dbname = '';
 
include "connect.php"; 
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
function validate($data) {
    global $conn; 
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = addslashes($data); 
    return $data; 
}
if ( isset($_POST['firstName']) && !empty($_POST['firstName']) && isset($_POST['lastName']) && !empty($_POST['lastName'])) {
    $firstname = $_POST['firstName']; 
    $lastname = $_POST['lastName']; 
    $eventname = $_POST['eventName'];
    $firstname = validate($firstname); 
    $lastname = validate($lastname);
    $eventname = validate($eventname);  
    $sql = "INSERT INTO patrons (firstName, lastName, eventName) VALUES ('$firstname', '$lastname', '$eventname')"; 
    global $conn; 
    $conn -> exec($sql);
} 

if (isset($_GET["Events"])) {
    $event = $_GET["Events"];
}

$stmt = $conn->prepare("SELECT firstName, lastName, eventName, eventTimeStamp FROM patrons");
// $stmt -> execute([$event]);
$stmt -> execute();
$stmt -> setFetchMode(PDO::FETCH_ASSOC);
$tableRow = $stmt -> fetchAll(); 

$jsonTable = json_encode($tableRow);

echo $jsonTable; 
