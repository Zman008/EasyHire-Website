<?php 
    include("title_bar.php");
    include("db_connect.php");
    session_start();

    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
    } else {
        $id = $_SESSION['user_id'];
    }

    $query = "SELECT * FROM user WHERE user_id = {$id}"; 
    $result = mysqli_query($connection, $query);

    if ($result) {
        $user = mysqli_fetch_assoc($result);
    } else {
        echo "Error fetching user data: " . mysqli_error($connection);
    }

    mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <title>User Info</title>
    <link rel="stylesheet" href="user.css">
</head>
<body>
    <div class="cont-body">
        <div class="container">
            <div class="user-info-title">User Information
            </div>
            <span class="inbox-icon material-symbols-outlined" onclick="window.location.href='user_inbox.php';">mail</span>
            <?php if (isset($user)): ?>
                <div><span class="left">Username</span> <span><?php echo $user['name']; ?></span></div>
                <div><span class="left">Phone</span> <span><?php echo $user['contact']; ?></span></div>
                <div><span class="left">Email</span> <span><?php echo $user['email']; ?></span></div>
                <div><span class="left">Address</span> <span><?php echo $user['address']; ?></span></div>
            <?php else: ?>
                <div>No user data found.</div>
            <?php endif; ?>
            <div class="buttons">
                <button onclick="window.location.href='edit.php';">Edit Profile</button>
                <button onclick="window.location.href='passwordChange.php';">Change Password</button>
                <button onclick="confirmDeletion()">Delete Account</button>
                <button onclick="window.location.href='savedpost.php';">Saved Posts</button>
            </div>
            <div class="logout">
                <button onclick="window.location.href='logout.php';">Logout</button>
            </div>
        </div>
    </div>

    <script>
        function confirmDeletion() {
            if (confirm("Are you sure you want to delete your account?")) {
                window.location.href = "delete.php";
            }
        }
    </script>
</body>
</html>