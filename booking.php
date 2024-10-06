<?php

session_start();
include("db_connect.php");
include("title_bar.php");
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!empty($_POST['message']) && !empty($_POST['time']) && !empty($_POST['date'])) {

        $message = $_POST['message'];
        $time = $_POST['time'];
        $date = $_POST['date'];
        // Default status for new booking
        $status = 'Pending';

        // Insert booking into the database
        $query = "INSERT INTO booking (user_id, post_id, date, time, status, message) 
                      VALUES ('$id', '$post_id', '$date', '$time', '$status', '$message')";

        if (mysqli_query($connection, $query)) {
            echo "Booking request sent successfully!";
            header("location: user_profile.php");
        } else {
            echo "Error: " . mysqli_error($connection);
        }
    } else {
        echo "All fields are required!";
    }
}

mysqli_close($connection);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="book.css">
    <title>Booking Form</title>
</head>

<body>

    <div class="booking-form">
        <h2>Book Service: </h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . "?post_id=" . $post_id; ?>">
            <label for="message">Message to Provider:</label>
            <textarea name="message" id="message" rows="4" placeholder="Write your message here..." required></textarea>

            <label for="time">Preferred Time:</label>
            <select name="time" id="time" required>
                <option value="08:00 AM">08:00 AM</option>
                <option value="09:00 AM">09:00 AM</option>
                <option value="10:00 AM">10:00 AM</option>
                <option value="11:00 AM">11:00 AM</option>
                <option value="12:00 PM">12:00 PM</option>
                <option value="01:00 PM">01:00 PM</option>
                <option value="02:00 PM">02:00 PM</option>
                <option value="03:00 PM">03:00 PM</option>
                <option value="04:00 PM">04:00 PM</option>
                <option value="05:00 PM">05:00 PM</option>
            </select>

            <label for="date">Preferred Date:</label>
            <input type="date" name="date" id="date" required>

            <button type="submit">Send Booking Request</button>
        </form>
    </div>

</body>

</html>
<?php

?>