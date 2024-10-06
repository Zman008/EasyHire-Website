<?php
include("title_bar.php");
include("db_connect.php");

if (isset($_GET['q'])) {
    $search_query = htmlspecialchars($_GET['q']);
    echo "<h1 style='margin: 1em 2em;'>Search Results for: " . $search_query . "</h1>";
} else {
    echo "<h1>No search query provided.</h1>";
    header("Location: index.php");
}

if (isset($_COOKIE['region']) && $_COOKIE['region'] != "All") {
    $query = "SELECT * FROM job_post j 
            JOIN provider p ON j.provider_id = p.provider_id 
            WHERE (title LIKE '%$search_query%' OR catagory LIKE '%$search_query%') AND region = '{$_COOKIE['region']}'";
} else {
    $query = "SELECT * FROM job_post j 
            JOIN provider p ON j.provider_id = p.provider_id 
            WHERE title LIKE '%$search_query%' OR catagory LIKE '%$search_query%'";
}

$result = mysqli_query($connection, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="search.css">
</head>
<body>
    <div class="container">
        <?php 
        if (mysqli_num_rows($result) > 0) {
            while ($post = mysqli_fetch_assoc($result)) {
                echo "<div class='post'>";
                echo "<h2><a href='post_details.php?id={$post['post_id']}'>" . htmlspecialchars($post['title']) . "</a></h2>";
                echo "<div class='post-detail'><span class='left'>Category</span> " . $post['catagory'] . "</div>";
                echo "<div class='post-detail'><span class='left'>Provider</span> <a href='provider_user.php?id={$post['provider_id']}'>" . $post['name'] . "</a></div>";
                echo "<div class='post-detail'><span class='left'>Region</span> " . $post['region'] . "</div>";
                echo "<div class='post-detail'><span class='left'>Details</span> " . $post['details'] . "</div>";
                echo "<div class='post-detail'><span class='left'>Date</span> " . $post['date'] . "</div>";
                echo "</div>";
            }

            mysqli_free_result($result);
        } else {
            echo "<h2>No results found.</h2>";
        }

        mysqli_close($connection);
        ?>
    </div>
</body>
</html>