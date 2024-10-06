<?php
    session_start();
    if (isset($_SESSION['user_id'])) {
        header("Location: user_profile.php");
    } else if (isset($_SESSION['provider_id'])) {
        header("Location: provider_profile.php");
    } else {
        header("Location: login.php");
    }
?>