<?php 
    session_start();
    include("db_connect.php");
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
    } else {
        $id = $_SESSION['user_id'];
    }

    if (isset($_GET['post_id'])) {
        $post_id = intval($_GET['post_id']); 
    } else {
        echo "No post ID provided.";
        exit;
    }

    // Variables for storing messages
    $ratingErr = $commentErr = $reviewMsg = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $rating = filter_input(INPUT_POST, "rating", FILTER_VALIDATE_INT, ["options" => ["min_range" => 1, "max_range" => 5]]);
        $comment = filter_input(INPUT_POST, "comment", FILTER_SANITIZE_SPECIAL_CHARS);
        
        // Validate input
        if (!$rating) {
            $ratingErr = "Please provide a rating between 1 and 5.";
        }
        if (empty($comment)) {
            $commentErr = "Comment cannot be empty.";
        }

        // If no errors, proceed with inserting review
        if (empty($ratingErr) && empty($commentErr)) {
            $sql = "INSERT INTO review (user_id, post_id, ratings, comment) 
                    VALUES ('$id', '$post_id', '$rating', '$comment')";

            if (mysqli_query($connection, $sql)) {
                $reviewMsg = "Review submitted successfully!";
                header("Location: user_profile.php");
            } else {
                $reviewMsg = "Error: " . mysqli_error($connection);
            }
        }
    }

    mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Review</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 50px;
        }
        .review-form {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 60px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .form-control {
            margin-bottom: 15px;
        }
        .form-control label {
            display: block;
            font-size: 14px;
            margin-bottom: 5px;
        }
        .form-control input, .form-control select, .form-control textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-control input[type="submit"] {
            background-color: #fb0;
            color: white;
            border: none;
            cursor: pointer;
        }
        .form-control input[type="submit"]:hover {
            background-color:  rgb(225, 125, 2);
        }
        .errorMsg {
            color: red;
            font-size: 12px;
        }
        .reviewMsg {
            color: green;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>

    <form class="review-form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . "?post_id=" . $post_id; ?>">
        <h2>Submit Review</h2>

        <div class="form-control">
            <label for="rating">Rating (1-5)</label>
            <input type="number" id="rating" name="rating" min="1" max="5" required>
            <div class="errorMsg"><?php echo $ratingErr; ?></div>
        </div>

        <div class="form-control">
            <label for="comment">Comment</label>
            <textarea id="comment" name="comment" rows="4" required></textarea>
            <div class="errorMsg"><?php echo $commentErr; ?></div>
        </div>

        <div class="form-control">
            <input type="submit" value="Submit Review">
            <div class="reviewMsg"><?php echo $reviewMsg; ?></div>
        </div>
    </form>

</body>
</html>
