<?php
    session_start();
    include("db_connect.php");
    if (!isset($_SESSION['admin_username'])) {
        header("Location: admin_login.php");
    }

    $sql = "SELECT * FROM job_post JOIN provider ON job_post.provider_id = provider.provider_id";
    $result = mysqli_query($connection, $sql);
    $users = mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css">
    <title>Admin</title>
</head>
<body>   
    <div class="container">
        <button onclick="window.location.href='admin.php';">Users</button>
        <button onclick="window.location.href='admin_provider.php';">Providers</button>
        <button onclick="window.location.href='admin_posts.php';">Posts</button>
        <button onclick="window.location.href='logout.php';">Logout</button>
    </div>
    <h1>Provider</h1>
    <table border="1">
        <tr>
            <th>Title</th>
            <th>Category</th>
            <th>Provider</th>
            <th>Date</th>
            <th>Details</th>
            <th>Region</th>
        </tr>
        <?php foreach ($users as $user) { ?>
            <tr>
                <td><?php echo $user['title']; ?></td>
                <td><?php echo $user['catagory']; ?></td>
                <td><?php echo $user['name']; ?></td>
                <td><?php echo $user['date']; ?></td>
                <td><?php echo $user['details']; ?></td>
                <td><?php echo $user['region']; ?></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html> 
