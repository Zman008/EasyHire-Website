<?php
include("db_connect.php");

if (isset($_GET['id'])) {
    $post_id = intval($_GET['id']);
    $query = "SELECT * FROM job_post WHERE post_id = {$post_id}";
    $result = mysqli_query($connection, $query);

    if ($result) {
        $post = mysqli_fetch_assoc($result);
    } else {
        echo "Error fetching post details: " . mysqli_error($connection);
        exit;
    }
} else {
    echo "No post ID provided.";
    exit;
}

mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="post.css">
    <title><?php echo htmlspecialchars($post['title']); ?></title>
</head>
<body>
    <div class="cont-body">
        <div class="container" style="width: 60%">
            <div class="user-info-title"><?php echo htmlspecialchars($post['title']); ?></div>
            <div><span class="left">Category</span> <?php echo $post['catagory']; ?></div>
            <div><span class="left">Details</span> <?php echo $post['details']; ?></div>
            <div><span class="left">Date</span> <?php echo $post['date']; ?></div>
            <button onclick="window.location.href='provider_prof.php';">Back to My Posts</button>
        </div>
    </div>
</body>
</html>