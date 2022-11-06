<?php
    if(!session_id()) {
        session_start();
    }
    session_unset();
    session_destroy();
?>

<!DOCTYPE html>
<html lang="en"></html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="src/logout.css">
    <link rel="stylesheet" href="../templates/leftmenu.css">
	<title>Logout</title>
</head>
    <?php include('../templates/leftmenu.php'); ?>
        <div class="flex-default">
            <div class="flex-center">
                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
                <circle class="path circle" fill="none" stroke="#73AF55" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/>
                <polyline class="path check" fill="none" stroke="#73AF55" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 "/>
                </svg>
                <p>Successfully logged out!</p>
            </div>
        </div>
    </body>
</html>