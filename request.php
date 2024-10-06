<?php
ob_start();
include("db_connect.php");
include("title_bar.php");
session_start();

if (!isset($_SESSION['provider_id'])) {
    header("Location: provider_login.php");
} else {
    $id = $_SESSION['provider_id'];
}

if (isset($_GET['bid'])) {
    $booking_id = intval($_GET['bid']); 
        $action = $_GET['action'];

        if ($action == 'confirm') {

            $update_query = "UPDATE booking SET status = 'Confirmed' WHERE booking_id = '$booking_id' ";
            mysqli_query($connection, $update_query);
        } elseif ($action == 'reject') {

            $update_query = "UPDATE booking SET status = 'Reject' WHERE booking_id = '$booking_id' ";
            mysqli_query($connection, $update_query);
        }
        

        header("Location: request.php");
        exit();
    }



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="table_style.css">
    <title>Request page</title>
</head>

<body>
    <div>
        <h2>Requests</h2>
        <table>
            <tr>
                <th>Message</th>
                <th>CustomerName</th>
                <th>Contact</th>
                <th>Date</th>
                <th>time</th>
                <th>Choose</th>
            </tr>
            <?php
            include("db_connect.php");
            $query = "SELECT booking_id,message,user.name as un, user.contact as uc, booking.date as dt,booking.time as tt from booking join user on 
                user.user_id= booking.user_id join job_post on 
                job_post.post_id=booking.post_id join provider on 
                job_post.provider_id= provider.provider_id 
                where provider.provider_id= '$id' and status ='Pending';";

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
                    echo "<td>
                             <a href='request.php?bid={$post['booking_id']}&action=confirm' class='button'>Confirm</a>
                             <a href='request.php?bid={$post['booking_id']}&action=reject' class='button'>Reject</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                // If no pending requests, redirect to provider_prof.php
                header("Location: provider_prof.php");
                exit();
            }

            mysqli_close($connection);
            ?>
        </table>
    </div>
</body>

</html>