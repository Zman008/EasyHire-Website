<?php 
    $db_server = "localhost";
    $db_user = "root";
    $db_password = "";
    $db_name = "easyhire";
    $connection = "";

    try {
        $connection = mysqli_connect($db_server, 
                                        $db_user, 
                                        $db_password, 
                                        $db_name);
    } catch (mysqli_sql_exception) {
        die( "<small>Could not connect<small><br><br>");
    }
?>