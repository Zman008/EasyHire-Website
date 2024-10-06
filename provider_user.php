<?php 
    include("title_bar.php");
    include("db_connect.php");
    
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $query = "SELECT * FROM provider p 
                JOIN job_post j ON p.provider_id = j.provider_id
                WHERE j.provider_id = {$id}";
                $result = mysqli_query($connection, $query);
        if ($result) {
            $user = mysqli_fetch_assoc($result);
        } else {
            echo "Error fetching user data: " . mysqli_error($connection);
        }
    } else {
        header("Location: index.php");
    }


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
            <?php else: ?>
                <div>No user data found.</div>
            <?php endif; ?>
        </div>
        
        <div>
            <h2>Posts</h2>
            <table>
                <tr>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Details</th>
                    <th>Date</th>
                </tr>
                <?php 
                
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