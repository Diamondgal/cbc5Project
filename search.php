<!-- The file connects search.html to the database and allow for data to be pulled from the database and shown in a table based on the search terms set by the user on search.html. -->
<?php 
// The code below is for connecting to the database
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'test';
 
//the code below was commented out for testing.
// include "connect.php"; 

//The try/catch is for connecting to database.
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //The code for testing the connection of the code. This line will be print on page if the connection is sucessful.
    echo "Connection successful. :) <br>";
}
catch(PDOException $e) {
    //The code below will echo out a error message if the connection to the server fails
    echo "Connection failed: " . $e->getMessage();
}
//get the input of the search textbox on search.html
$search = $_POST['search'];

//sets the minimum length of the query
$min_length = 2;

if(strlen($search) >= $min_length){ //check length of $search to make sure the text box isn't empty and has a minimum length of 2
   
    //validate data
    $search = trim($search);
    $search = stripslashes($search);
    $search = htmlspecialchars($search);

    //Prepare statement for database to select data with search variable
    $stmt = $conn->prepare("SELECT firstName, lastName, eventName, 'timeStamp' FROM patrons WHERE eventName=?"); 
    $stmt -> execute([$search]);
    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
    $tableRow = $stmt -> fetchAll(); 
       
} else{
    echo "Minimum length is ".$min_length;
    return;
}

?>

<!-- Creates the table for the search results -->
<table>
    <thead>
        <th>firstName</th>
        <th>lastName</th>
        <th>eventName</th>
        <th>timeStamp</th>
    </thead>
    <?php
        foreach ($tableRow as $t) {
            echo "<tr>"; 
            echo "<td>" . $t['firstName'] . "</td>";
            echo "<td>" . $t['lastName'] . "</td>"; 
            echo "<td>" . $t['eventName'] . "</td>"; 
            echo "<td>" . $t['timeStamp'] . "</td>"; 
            echo "</tr>";
        }
    ?>    
</table>
