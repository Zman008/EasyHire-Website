<?php
include("title_bar.php");
include("db_connect.php");

if (isset($_GET['id'])) {
    $post_id = intval($_GET['id']);
    $query = "SELECT 
        title, catagory, j.provider_id, p.name as name, 
        p.contact, j.region, details, date, ratings, comment, u.name as user_name
        FROM job_post j 
        JOIN provider p ON j.provider_id = p.provider_id 
        LEFT JOIN review r ON j.post_id = r.post_id
        LEFT JOIN user u ON r.user_id = u.user_id
    WHERE j.post_id = {$post_id}";
    $result = mysqli_query($connection, $query);

    if ($result) {
        $post = mysqli_fetch_assoc($result);
    } else {
        echo "Error fetching post details: " . mysqli_error($connection);
        header("Location: index.php");
    }
} else {
    echo "No post ID provided.";
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="post.css">
    <link rel="stylesheet" href="table_style.css">
    <style>
        /* Text area for message input */
        .hiring-section textarea {
            height: 40px;
            /* Same height as button */
            padding: 8px;
            margin-right: 10px;
            /* Add space between textarea and button */
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 0.9em;
            resize: none;
        }
    </style>
    <title><?php echo htmlspecialchars($post['title']); ?></title>
</head>

<body>
    <div class="cont-body">
        <div class="container" style="width: 60%;margin-top: 200px;">
            <div class="user-info-title"><?php echo htmlspecialchars($post['title']); ?></div>
            <div><span class="left">Category</span> <?php echo $post['catagory']; ?></div>
            <div><span class="left">Provider</span> <a href="provider_user.php?id=<?php echo $post['provider_id']; ?>"><?php echo $post['name']; ?></a></div>
            <div><span class="left">Region</span> <?php echo $post['region']; ?></div>
            <div><span class="left">Details</span> <?php echo nl2br(html_entity_decode($post['details'])); ?></div>
            <div><span class="left">Date</span> <?php echo $post['date']; ?></div>
            <div><span class="left">Phone</span> <?php echo $post['contact']; ?></div>
            <div class="butt">
                <form class="review_save" method="GET" action="review.php">
                    <button class="review" type="submit" name="post_id" value="<?php echo $post_id; ?>">Review</button>
                </form>
                <form class="review_save" method="GET" action="postsaving.php">
                    <button class="review" type="submit" name="post_id" value="<?php echo $post_id; ?>">Save</button>
                </form>
                <form class="review_save" method="GET" action="booking.php">
                    <button class="hire-button" type="submit" name="post_id" value="<?php echo $post_id; ?>">Hire/Book</button>
                </form>

            </div>

        </div>
    </div>

    <div>
        <h2>Reviews</h2>
        <table>
            <tr>
                <th>User</th>
                <th>Rating</th>
                <th>Review</th>
            </tr>
            <?php

            $result = mysqli_query($connection, $query);

            if ($result) {
                while ($review = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $review['user_name'] . "</td>";
                    echo "<td>" . $review['ratings'] . "</td>";
                    echo "<td>" . $review['comment'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "Error fetching reviews: " . mysqli_error($connection);
            }

            mysqli_close($connection);
            ?>
        </table>
    </div>
    </div>
</body>

</html>