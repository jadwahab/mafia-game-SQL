<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");

/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$link = mysqli_connect("localhost", "mafia_db_user", "mafia_db_password", "mafiadb");
// $cookie = $_COOKIE["master_cookie"];
$room_name = $_GET["room_name"];
$nickname = $_GET["nickname"];
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 
// Attempt insert query execution
$sql = "INSERT INTO rooms (room_name) VALUES ('$room_name')";
$response = new stdClass();


if(mysqli_query($link, $sql)){
    // Obtain last inserted id
    $room_id = mysqli_insert_id($link);
    $response->room_id = $room_id;
    
    $sql = "INSERT INTO users (nickname, room_id) VALUES ('$nickname', $room_id)";
    if(mysqli_query($link, $sql)){
        $user_id = mysqli_insert_id($link);
        $response->user_id = $user_id;
        
    } else{
        $response->user_id = -1; // not available or error
    }
} else{
    $response->room_id = -1; // not available or error
}

$myJSON = json_encode($response);

echo $myJSON;

 
// Close connection
mysqli_close($link);
?>