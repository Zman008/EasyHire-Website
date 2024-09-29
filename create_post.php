<?php 
    include("db_connect.php");
    session_start();

    if (!isset($_SESSION['id'])) {
        header("Location: provider_login.php");
    } else {
        $id = $_SESSION['id'];
    }

    $query = "SELECT * FROM provider WHERE provider_id = {$id}"; 
    $result = mysqli_query($connection, $query);

    if ($result) {
        $provider = mysqli_fetch_assoc($result);
    } else {
        echo "Error fetching user data: " . mysqli_error($connection);
    }
?>

<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_SPECIAL_CHARS);
        $catagory = filter_input(INPUT_POST, "catagory", FILTER_SANITIZE_SPECIAL_CHARS);
        $details = filter_input(INPUT_POST, "details", FILTER_SANITIZE_SPECIAL_CHARS);
        $provider_id = $id;
        $date = date("Y-m-d");

        $sql = "INSERT INTO 
                job_post (title, catagory, details, provider_id, date)
                VALUES 
                ('$title', '$catagory', '$details', '$provider_id', '$date')";
        try {
            mysqli_query($connection, $sql);
            header("Location: provider_prof.php");
        } catch (mysqli_sql_exception) {
            echo "ERROR<br>";
        }
    }

    mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
    <link rel="stylesheet" href="register.css">
</head>
<body>
    <form class="registration-form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <h2 style="margin-top: 0px;">Create Post</h2>
        <div class="form-control">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" required>
        </div>
        <div class="form-control">
            <label for="catagory">Catagory</label>
            <select id="catagory" name="catagory">
                <option value="Photographer">Photographer</option>
                <option value="Handyman">Handyman</option>
                <option value="Tutor">Tutor</option>
                <option value="Car Mechanic">Car Mechanic</option>
                <option value="Plumber">Plumber</option>
                <option value="Tow Truck">Tow Truck</option>
                <option value="Electrician">Electrician</option>
                <option value="House Cleaner">House Cleaner</option>
                <option value="Painter">Painter</option>
                <option value="Landscaper">Landscaper</option>
                <option value="Personal Trainer">Personal Trainer</option>
                <option value="Massage Therapist">Massage Therapist</option>
                <option value="Makeup Artist">Makeup Artist</option>
                <option value="Hairstylist">Hairstylist</option>
                <option value="Event Planner">Event Planner</option>
                <option value="Others" selected>Others</option>
            </select>
        </div>
        <div class="form-control">
            <label for="details">Details</label>
            <textarea id="details" name="details" placeholder="Add a description" cols="80" rows="10"></textarea> 
        </div>  
        
        <div class="form-control">
            <input type="submit" value="Create">
        </div>
    </form>
</body>
</html>