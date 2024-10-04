<?php
include("title_bar.php");
include("db_connect.php");

if (isset($_GET['q'])) {
    $search_query = htmlspecialchars($_GET['q']);
    echo "<h1>Search Results for: " . $search_query . "</h1>";
} else {
    echo "<h1>No search query provided.</h1>";
    header("Location: index.php");
}

$query = "SELECT * FROM job_post WHERE title LIKE '%$search_query%' OR catagory LIKE '%$search_query%'";
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
                $queryProvider = "SELECT * FROM provider WHERE provider_id = {$post['provider_id']}";
                $resultProvider = mysqli_query($connection, $queryProvider);
                $provider = mysqli_fetch_assoc($resultProvider);

                echo "<div class='post'>";
                echo "<h2><a href='post_details.php?id={$post['post_id']}'>" . htmlspecialchars($post['title']) . "</a></h2>";
                echo "<div><span class='left'>Category</span> " . $post['catagory'] . "</div>";
                echo "<div><span class='left'>Provider</span> <a href='provider_prof.php?id={$provider['provider_id']}'>" . $provider['name'] . "</a></div>";
                echo "<div><span class='left'>Details</span> " . $post['details'] . "</div>";
                echo "<div><span class='left'>Date</span> " . $post['date'] . "</div>";
                echo "</div>";

                mysqli_free_result($resultProvider);
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