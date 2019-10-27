<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");

/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$link = mysqli_connect("localhost", "mafia_db_user", "mafia_db_password", "mafiadb");
// $cookie = $_COOKIE["master_cookie"];
$room_name = $_GET["room_name"];
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 
// Attempt insert query execution
$sql = "SELECT * from users u JOIN rooms r ON r.room_id=u.room_id WHERE r.room_name='$room_name'";
$response = new stdClass();

$sth = mysqli_query($link, $sql);
$rows = array();

if($sth){
    while($r = mysqli_fetch_assoc($sth)) {
        $rows[] = $r;
    }
    $response->status = 1;
} else{
    $response->status = 0; // not available or error
}

$response->data = $rows;
$myJSON = json_encode($response);

echo $myJSON;

 
// Close connection
mysqli_close($link);
?>