<?php 
    include("title_bar.php");
    include("db_connect.php");
    session_start();

    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
    } else {
        $id = $_SESSION['user_id'];
    }
    
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="table_style.css">
    <title>Document</title>
</head>
<body>
    <div>
        <h2>Requests</h2>
        <table>
            <tr>
                <th>Message</th>
                <th>Provider Name</th>
                <th>Contact</th>
                <th>Date</th>
                <th>time</th>
                <th>Status</th>
            </tr>
            <?php

            $query = "SELECT status,booking_id,message,provider.name as un, provider.contact as uc, booking.date as dt,booking.time as tt from booking join user on 
                user.user_id= booking.user_id join job_post on 
                job_post.post_id=booking.post_id join provider on 
                job_post.provider_id= provider.provider_id 
                where user.user_id= '$id' ;";

            $result = mysqli_query($connection, $query);
            $bid = "";
            if ($result && mysqli_num_rows($result) > 0) {
                while ($post = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $post['message'] . "</td>";
                    echo "<td>" . $post['un'] . "</td>";
                    echo "<td>" . $post['uc'] . "</td>";
                    echo "<td>" . $post['dt'] . "</td>";
                    echo "<td>" . $post['tt'] . "</td>";
                    echo "<td>" . $post['status'] . "</td>";
                    
                    echo "</tr>";
                }
            } else {
                // If no pending requests, redirect to provider_prof.php
                header("Location: user_profile.php");
                exit();
            }

            mysqli_close($connection);
            ?>
        </table>
    </div>
</body></html>