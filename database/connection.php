<?php   
    $hostname = "localhost";
    $dbname = "sir";
    $username = "root";
    $password = "123";

    $mysqli = new mysqli($hostname, $username, $password, $dbname);

    if ($mysqli->connect_error) {
        echo "<script>console.error('Error connecting to database: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error . "');</script>";
    }else{
        echo "<script>console.log('Connected');</script>";
    }
?>