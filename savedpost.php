<?php 
    include("title_bar.php");
    include("db_connect.php");
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header("Location: provider_login.php");
    } else {
        $id = $_SESSION['user_id'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="table_style.css">
</head>
<body>
<div>
            <h2>My Saved Posts</h2>
            <table>
                <tr>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Details</th>
                    <th>Date</th>
                </tr>
                <?php 


                $query = "SELECT * FROM saved_posts join job_post on saved_posts.post_id = job_post.post_id and user_id = {$id} ";
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
</body>
</html>