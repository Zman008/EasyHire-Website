<?php
    session_start();
    if (isset($_SESSION['user_id'])) {
        header("Location: user_profile.php");
    } else {
        header("Location: login.php");
    }
?>