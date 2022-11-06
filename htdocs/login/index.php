<?php
    session_start();
    
    $errors =  array(
        'username'  => '',
        'password' => '',
        'account' => '',
    );

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

        if (empty($username)) {
            $errors['username'] = "Make sure to enter a username";
        } 
        else if (empty($password)){
            $errors['password'] = "Make sure to enter a password";
        }
        else {
            $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) === 1) {
                $row = mysqli_fetch_assoc($result);
                if ($row['username'] === $username && $row['password'] === $password) {
                    header('Location: /dashboard', true, 303);
                    exit;
                }
                else {
                    $errors['account'] = "Username or password is incorrect";
                }
            }
            else {
                $errors['account'] = "Username or password is incorrect";
            }
        }
        mysqli_close($conn);
        $_SESSION['errors'] = $errors;
        header('Location: /login', true, 303);
        exit;
    } 
    else if ($request_method === 'GET') {
        if (isset($_SESSION['errors'])) {
            $errors = $_SESSION['errors'];
            unset($_SESSION['errors']);
        }

        if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];
            unset($_SESSION['username']);
        }
    }
?>

<!DOCTYPE html>
<html lang="en"></html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="src/login_styles.css">
    <link rel="stylesheet" href="../templates/leftmenu.css">
	<title>Login</title>
</head>
    <?php include('../templates/leftmenu.php'); ?>
        <div class="flex-default">
            <div class="flex-center">
                <div class="login">
                    <form action="index.php" method="post">
                        <p class="title">Visitor Login</p>

                        <?php if ($errors['username'] == "Make sure to enter a username") : ?>
                        <p class="error"><?=$errors['username'] ?? ''?></p>
                        <?php endif ?>
                        <?php if ($errors['password'] == "Make sure to enter a password") : ?>
                        <p class="error"><?=$errors['password'] ?? ''?></p>
                        <?php endif ?>
                        <?php if ($errors['account'] == "Username or password is incorrect") : ?>
                        <p class="error"><?=$errors['account'] ?? ''?></p>
                        <?php endif ?>

                        <label>Username:</label>
                        <input type="text" name="username" placeholder="Username" minlength="1" maxlength="12" required><br>
                        <label>Password:</label>
                        <input type="password" name="password" placeholder="Password" minlength="8" maxlength ="24" required><br> 
                        <button type="submit">Login</button>
                        <p class="noaccount"> Don't have an account? <a href = "/register"> Make an account</a> here.</p> 
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>