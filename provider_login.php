<?php
    session_start();
    include("db_connect.php");

    $usernameErr = "";
    $passwordErr = "";
    function checkUsername($username) {
        global $connection;
        $sql = "SELECT * FROM provider WHERE name = '$username'";
        $result = mysqli_query($connection, $sql);
        if (mysqli_num_rows($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    function checkPassword($username, $password) {
        global $connection;
        $sql = "SELECT * FROM provider WHERE name = '$username'";
        $result = mysqli_query($connection, $sql);
        $row = mysqli_fetch_assoc($result);
        if ($row['password'] == $password) {
            return true;
        } else {
            return false;
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

        if (!checkUsername($username)) {
            $usernameErr = "Username does not exist";
        } else if (!checkPassword($username, $password)) {
            $passwordErr = "Incorrect Password";
        } else {
            $sql = "SELECT * FROM provider WHERE name = '$username'";
            $result = mysqli_query($connection, $sql);
            $row = mysqli_fetch_assoc($result);
            $_SESSION['provider_id'] = $row['provider_id'];
            $_SESSION['username'] = $row['name'];
            header("Location: provider_prof.php");
        }
    }

    mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Provider Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="container">
        <form class="registration-form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <h2 style="margin-top: 0px;">Provider Login</h2>
            <div class="form-control">
                <input type="text" id="username" name="username" placeholder="Username" required>
                <div class="errorMsg"><?php echo $usernameErr ?></div>
            </div>
            <div class="form-control">
                <input type="password" id="password" name="password" placeholder="Password" required>
                <div class="errorMsg"><?php echo $passwordErr ?></div>
            </div>
            <div class="form-control">
                <input type="submit" value="Login">
            </div>
            <a href="provider_register.php" style="font-size: small">Register as a new Provider</a>
        </form>
    </div>
</body>
</html>
