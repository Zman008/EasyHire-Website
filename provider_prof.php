<?php 
    include("db_connect.php");
    include("title_bar.php");
    session_start();

    if (!isset($_SESSION['provider_id'])) {
        header("Location: provider_login.php");
    } else {
        $id = $_SESSION['provider_id'];
    }

    $query = "SELECT * FROM provider WHERE provider_id = {$id}"; 
    $result = mysqli_query($connection, $query);

    if ($result) {
        $user = mysqli_fetch_assoc($result);
    } else {
        echo "Error fetching user data: " . mysqli_error($connection);
    }


    $query_pending = "SELECT COUNT(booking_id) AS pending_count 
                      FROM booking 
                      JOIN job_post ON booking.post_id = job_post.post_id 
                      JOIN provider ON provider.provider_id = job_post.provider_id  
                      WHERE provider.provider_id = {$id} AND booking.status = 'Pending'";

    // Execute the query
    $result_pending = mysqli_query($connection, $query_pending);

    // Check if the query was successful
    if ($result_pending) {
        $pending_booking = mysqli_fetch_assoc($result_pending)['pending_count'];
        
    } else {
        echo "Error: " . mysqli_error($connection);
    }

    mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Provider Info</title>
    <link rel="stylesheet" href="user.css">
    <link rel="stylesheet" href="table_style.css">
</head>
<body>
    <div class="cont-body">
        <div class="container">
            <div class="user-info-title">Provider Information</div>
            <?php if (isset($user)): ?>
                <div><span class="left">Username</span> <span><?php echo htmlspecialchars($user['name']); ?></span></div>
                <div><span class="left">Phone</span> <span><?php echo htmlspecialchars($user['contact']); ?></span></div>
                <div><span class="left">Address</span> <span><?php echo htmlspecialchars($user['address']); ?></span></div>
                <div><span class="left">Email</span> <span><?php echo htmlspecialchars($user['email']); ?></span></div>
                <div><span class="left">Pending request</span> <span><a href="request.php"><?php echo $pending_booking; ?></a></span></div>
            <?php else: ?>
                <div>No user data found.</div>
            <?php endif; ?>
            <div class="buttons">
                <button onclick="window.location.href='create_post.php';">Create Post</button>
                <button onclick="window.location.href='allreq.php';">Inbox</button>
                <button onclick="window.location.href='logout.php';">Logout</button>
            </div>
        </div>
        
        <div>
            <h2>My Posts</h2>
            <table>
                <tr>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Details</th>
                    <th>Date</th>
                </tr>
                <?php 
                include("db_connect.php");
                $query = "SELECT * FROM job_post WHERE provider_id = {$id}";
                $result = mysqli_query($connection, $query);
                
                if ($result) {
                    while ($post = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td><a href='post_details.php?id=" . $post['post_id'] . "'>" . $post['title'] . "</a></td>";
                        echo "<td>" . $post['catagory'] . "</td>";
                        echo "<td>" . $post['details'] . "</td>";
                        echo "<td>" . $post['date'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "Error fetching posts: " . mysqli_error($connection);
                }
                
                mysqli_close($connection);
                ?>
            </table>
        </div>
    </div>
</body>
</html>