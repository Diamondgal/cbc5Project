<a href="hostPage.html">Back to Host Page</a>

<!DOCTYPE HTML>
<html lang="en">
<head>
   
</head>
<body>
    <div class = "createEvent">
<h1>Update your list of events</h1>
<form method="get"> 
    New Event Name:
    <input type ="text" id="createEvent" name="createEvent">
    <input type="submit" value="Create Your Event" onclick="createEvent()">
</form>

</body>
        
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

function validate($data) {
    global $conn; 
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = addslashes($data); 
    return $data; 
}

if (isset($_GET['createEvent']) && !empty($_GET['createEvent'])) {
    $createEvent = $_GET['createEvent'];
    $createEvent = validate($createEvent);
    $sql = "INSERT INTO events (createEvent) VALUE ('$createEvent')"; 
    global $conn; 
    $conn -> exec($sql);

    echo "You have successfully added new event!";
} 

?>