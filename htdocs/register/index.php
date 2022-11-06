<?php
    session_start();
    $error = false;
    $username = '';

    $request_method = strtoupper($_SERVER['REQUEST_METHOD']);
    if ($request_method === 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $_SESSION['username'] = $username;

        $conn = mysqli_connect('localhost', 'admin', 'pass', 'accounts');
        if (!$conn) {
            echo 'Error:' . mysqli_connect_error();
        }

        $sql = "INSERT INTO users VALUES ('".$username."', '".$password."', '', '')";

        try {
            mysqli_query($conn, $sql);
            header('Location: /dashboard', true, 303);
            exit;
        }
        catch (Exception $e) {
            if (mysqli_errno($conn) == 1062) {
                $error = true;
            }
        }
        mysqli_close($conn);

        $_SESSION['error'] = $error;

        header('Location: /register', true, 303);
        exit;
    } 
    else if ($request_method === 'GET') {
        if (isset($_SESSION['error'])) {
            $error = $_SESSION['error'];
            unset($_SESSION['error']);
        }

        if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];
            unset($_SESSION['username']);
        }
    }



?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="src/register.css">
        <link rel="stylesheet" href="../templates/leftmenu.css">
        <title>Register an Account</title>
    </head>
    <?php include('../templates/leftmenu.php'); ?>
        <div class="flex-default">
            <div class="flex-center">
                <div class="register">
                    <p class="title">Register an Account</p>
                    <form action="index.php" method="post">
                        <?php if ($error) : ?>
                            <p class="error">An account with that username already exists</p>
                        <?php endif ?>
                        <label>Create a Username:</label>
                        <input type="username" name="username" placeholder="Enter Username" minlength="1" maxlength="12" required><br>
                        <div class="notmatch">Passwords Don't Match</div>
                        <div class="pleaseenter">Please Enter in a Password</div>
                        <label>Create a Password:</label>
                        <input id="password1" name="password" type="password" placeholder="Enter Password" minlength="8" maxlength="24" required><br>
                        <label>Confirm Password:</label>
                        <input id="password2" type="password" placeholder="Confirm Password" minlength="8" maxlength="24" required><br>
                        <button type="submit">Register</button>
                    </form>
                    <p class="hasaccount"> Already have an account? <a href="/login"> Login</a> here.</p> 
                </div>
        </div>
    </body>
    <script src="src/index.js"></script>
</html>