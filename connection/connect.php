<?php
    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "db_pos";

    $conn = mysqli_connect($server, $username, $password, $database);

    if($conn == false){
        die("Connection error");
    }
?>