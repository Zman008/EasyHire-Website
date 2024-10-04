<?php
    session_start();
    include("db_connect.php");
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
    } else {
        $id = $_SESSION['user_id'];

    }

    if (isset($_GET['post_id'])) {
        $post_id = intval($_GET['post_id']); 

    } else {
        echo "No post ID provided.";
        exit;
    }
    $check_query = "INSERT into saved_posts values ('$id','$post_id') ";
    $check_result = mysqli_query($connection, $check_query);
    header("location:savedpost.php");
?>