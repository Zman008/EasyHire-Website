<?php
include("title_bar.php");
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

    $queryProvider = "SELECT * FROM provider WHERE provider_id = {$post['provider_id']}";
    $resultProvider = mysqli_query($connection, $queryProvider);

    if ($resultProvider) {
        $provider = mysqli_fetch_assoc($resultProvider);
    } else {
        echo "Error fetching provider details: " . mysqli_error($connection);
        exit;
    }
} else {
    echo "No post ID provided.";
    header("Location: index.php");
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
            <div><span class="left">Provider</span>  <a href="provider_user.php?id=<?php echo $provider['provider_id']; ?>"><?php echo $provider['name']; ?></a></div>
            <div><span class="left">Region</span> <?php echo $post['region']; ?></div>
            <div><span class="left">Details</span> <?php echo nl2br(html_entity_decode($post['details'])); ?></div>
            <div><span class="left">Date</span> <?php echo $post['date']; ?></div>
            <div><span class="left">Phone</span> <?php echo $provider['contact']; ?></div>
            <div class="butt">
            <form class="review_save" method="GET" action="review.php">
                <button class="review" type="submit" name="post_id" value="<?php echo $post_id; ?>">Review</button>
            </form>
            <form class="review_save" method="GET" action="postsaving.php">
                <button class="review" type="submit" name="post_id" value="<?php echo $post_id; ?>">Save</button>
            </form>
            </div>
        </div>
    </div>
</body>
</html>