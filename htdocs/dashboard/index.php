<?php
    session_start();

    $conn = mysqli_connect('localhost', 'admin', 'pass', 'accounts');
    if (!$conn) {
        echo 'Error:' . mysqli_connect_error();
    }
    $username = $_SESSION['username'];
    $sql = "SELECT * FROM vehicles WHERE user='$username'";

    $result = mysqli_query($conn, $sql);
    $numberOfRows = mysqli_num_rows($result);

    $i = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $vehicles[$i]['license'] = $row['license'];
        $vehicles[$i]['year'] = $row['year'];
        $vehicles[$i]['make'] = $row['make'];
        $vehicles[$i]['model'] = $row['model'];
        $vehicles[$i]['state'] = $row['state'];
        $vehicles[$i]['time'] = $row['time'];
        $i++;
    }
    
    $due = date('Y-m-d H:i:s');

    $request_method = strtoupper($_SERVER['REQUEST_METHOD']);


    if( $request_method == "POST" and isset($_POST['remove0'])) {
        $license0 = $vehicles[0]['license'];
        $state0 = $vehicles[0]['state'];
        $sql = "DELETE FROM vehicles WHERE license='$license0' AND state='$state0'";
        mysqli_query($conn, $sql);
        header('Location: /dashboard', true, 303);
        exit;
    }
    else if( $request_method == "POST" and isset($_POST['remove1'])) {
        $license1 = $vehicles[1]['license'];
        $state1 = $vehicles[1]['state'];
        $sql = "DELETE FROM vehicles WHERE license='$license1' AND state='$state1'";
        mysqli_query($conn, $sql);
        header('Location: /dashboard', true, 303);
        exit;
    }
    else if( $request_method == "POST" and isset($_POST['remove2'])) {
        $license2 = $vehicles[2]['license'];
        $state2 = $vehicles[2]['state'];
        $sql = "DELETE FROM vehicles WHERE license='$license2' AND state='$state2'";
        mysqli_query($conn, $sql);
        header('Location: /dashboard', true, 303);
        exit;
    }
    else if( $request_method == "POST" and isset($_POST['checkin0'])) {
        $license0 = $vehicles[0]['license'];
        $state0 = $vehicles[0]['state'];
        $sql = "UPDATE vehicles SET time='$due' WHERE license='$license0' AND state='$state0'";
        mysqli_query($conn, $sql);
        header('Location: /dashboard', true, 303);
        exit;
    }   
    else if( $request_method == "POST" and isset($_POST['checkin1'])) {
        $license1 = $vehicles[1]['license'];
        $state1 = $vehicles[1]['state'];
        $sql = "UPDATE vehicles SET time='$due' WHERE license='$license1' AND state='$state1'";
        mysqli_query($conn, $sql);
        header('Location: /dashboard', true, 303);
        exit;
    }
    else if( $request_method == "POST" and isset($_POST['checkin2'])) {
        $license2 = $vehicles[2]['license'];
        $state2 = $vehicles[2]['state'];
        $sql = "UPDATE vehicles SET time='$due' WHERE license='$license2' AND state='$state2'";
        mysqli_query($conn, $sql);
        header('Location: /dashboard', true, 303);
        exit;
    }
    else if ($request_method === 'POST' and isset($_POST['formsubmit'])) {
        $license = strtoupper($_POST['license']);
        $year = $_POST['year'];
        $make = $_POST['make'];
        $model = $_POST['model'];
        $state = $_POST['state'];
        $error = false;

        $sql = "INSERT INTO vehicles VALUES ('".$license."', '".$username."', '".$year."', '".$make."', '".$model."', '".$state."', '".$time."')";
        try {
            mysqli_query($conn, $sql);
        }
        catch (Exception $e) {
            if (mysqli_errno($conn) == 1062) {
                $error = true;
            }
        }
        
        mysqli_close($conn);
        
        $_SESSION['error'] = $error;
        
        header('Location: /dashboard', true, 303);
        exit;
    } 
    else if ($request_method === 'GET') {
        if (isset($_SESSION['error'])) {
            $error = $_SESSION['error'];
            unset($_SESSION['error']);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<script src="../search/src/index.js"></script>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="src/dashboard.css">
    <link rel="stylesheet" href="../templates/leftmenu.css">
	<title>My Info</title>
</head>
        <?php include('../templates/leftmenu.php'); ?>
        <div class="flex-default">
            <div class="dashboard">
                <p class="welcome">Welcome <?=$_SESSION['username'] ?? '' ?>!</p>
                <p class="title">My Vehicles</p>
                <div class="vehicles">
                    <?php if ($numberOfRows >= 1) : ?>
                    <div class="box">
                        <div>
                            <p class="licensenum"><?=$vehicles[0]['license'] ?? ''?></p>
                            <p style="display: inline-block;"><?=$vehicles[0]['state'] ?? ''?></p>
                        </div>
                        <p><?=$vehicles[0]['year'] ?? ''?> <?=$vehicles[0]['make'] ?? ''?> <?=$vehicles[0]['model'] ?? ''?></p>
                        <?php if(((strtotime(date('Y-m-d H:i:s')) - strtotime($vehicles[0]['time'])) / 3600) >= 3): ?>
                        <form action="index.php" method="post" class="checkin">
                            <input type="submit" name="checkin0" value="Check in"/>
                        </form>
                        <?php else: ?>
                            <p class="checkedin">Checked in!</p>
                        <?php endif ?>
                        <form action="index.php" method="post" class="remove">
                            <input type="submit" name="remove0" value="Remove"/>
                        </form>
                    </div>
                    <?php endif ?>

                    <?php if ($numberOfRows >= 2) : ?>
                    <div class="box">
                        <div>
                            <p class="licensenum"><?=$vehicles[1]['license'] ?? ''?></p>
                            <p style="display: inline-block;"><?=$vehicles[1]['state'] ?? ''?></p>
                        </div>
                        <p><?=$vehicles[1]['year'] ?? ''?> <?=$vehicles[1]['make'] ?? ''?> <?=$vehicles[1]['model'] ?? ''?></p>
                        <?php if(((strtotime(date('Y-m-d H:i:s')) - strtotime($vehicles[1]['time'])) / 3600) >= 3): ?>
                        <form action="index.php" method="post" class="checkin">
                            <input type="submit" name="checkin1" value="Check in"/>
                        </form>
                        <?php else: ?>
                            <p class="checkedin">Checked in!</p>
                        <?php endif ?>
                        <form action="index.php" method="post" class="remove">
                            <input type="submit" name="remove1" value="Remove"/>
                        </form>
                    </div>
                    <?php endif ?>
                    
                    <?php if ($numberOfRows == 3) : ?>
                    <div class="box">
                        <div>
                            <p class="licensenum"><?=$vehicles[2]['license'] ?? ''?></p>
                            <p style="display: inline-block;"><?=$vehicles[2]['state'] ?? ''?></p>
                        </div>
                        <p><?=$vehicles[2]['year'] ?? ''?> <?=$vehicles[2]['make'] ?? ''?> <?=$vehicles[2]['model'] ?? ''?></p>
                        <?php if(((strtotime(date('Y-m-d H:i:s')) - strtotime($vehicles[2]['time'])) / 3600) >= 3): ?>
                        <form action="index.php" method="post" class="checkin">
                            <input type="submit" name="checkin2" value="Check in"/>
                        </form>
                        <?php else: ?>
                            <p class="checkedin">Checked in!</p>
                        <?php endif ?>
                        <form action="index.php" method="post" class="remove">
                            <input type="submit" name="remove2" value="Remove"/>
                        </form>
                    </div>
                    <?php endif ?>

                    <?php if ($numberOfRows < 3) : ?>
                        <img src="img/plus.png" onclick="toggleForm()" class="plus">
                    <?php endif ?>

                </div>
            </div>
        </div>
        <div class="blur">
            <form action="index.php" method="post" class="form">
                <img src="img/x.png" onclick="toggleForm()" alt="X" class="exit">
                <p class="formtitle">Add a Vehicle</p>
                <div>
                    <label>License Plate</label>
                    <input type="license" name="license" placeholder="Enter License Plate" minlength="6" maxlength="6" required><br>
                </div>
                <div class="dropdown">
                    <label for="state" id="state">State:</label>
                    <select name="state" id="state">
                    <option value="AL">AL</option>
                    <option value="AK">AK</option>
                    <option value="AZ">AZ</option>
                    <option value="AR">AR</option>
                    <option value="CA">CA</option>
                    <option value="CO">CO</option>
                    <option value="CT">CT</option>
                    <option value="DE">DE</option>
                    <option value="FL">FL</option>
                    <option value="GA">GA</option>
                    <option value="HI">HI</option>
                    <option value="IA">IA</option>
                    <option value="ID">ID</option>
                    <option value="IL">IL</option>
                    <option value="IN">IN</option>
                    <option value="KS">KS</option>
                    <option value="KY">KY</option>
                    <option value="LA">LA</option>
                    <option value="ME">ME</option>
                    <option value="MD">MD</option>
                    <option value="MA">MA</option>
                    <option value="MI">MI</option>
                    <option value="MN">MN</option>
                    <option value="MS">MS</option>
                    <option value="MO">MO</option>
                    <option value="MT">MT</option>
                    <option value="NE">NE</option>
                    <option value="NV">NV</option>
                    <option value="NH">NH</option>
                    <option value="NJ">NJ</option>
                    <option value="NM">NM</option>
                    <option value="NY">NY</option>
                    <option value="NC">NC</option>
                    <option value="ND">ND</option>
                    <option value="OH">OH</option>
                    <option value="OK">OK</option>
                    <option value="OR">OR</option>
                    <option value="PA">PA</option>
                    <option value="RI">RI</option>
                    <option value="SC">SC</option>
                    <option value="SD">SD</option>
                    <option value="TN">TN</option>
                    <option value="TX">TX</option>
                    <option value="UT">UT</option>
                    <option value="VT">VT</option>
                    <option value="VA">VA</option>
                    <option value="WA">WA</option>
                    <option value="WV">WV</option>
                    <option value="WI">WI</option>
                    <option value="WY">WY</option>
                    </select>
                </div>
                <div>
                    <label>Year </label>
                    <input type="year" name="year" placeholder="Enter Year" minlength="4" maxlength="4" required><br>
                </div>
                <div>
                    <label>Make </label>
                    <input type="make" name="make" placeholder="Enter Make" minlength="1" maxlength="16" required><br>
                </div>
                <div>
                    <label>Model</label>
                    <input type="model" name="model" placeholder="Enter Model" minlength="1" maxlength="16" required><br>
                </div>
                <input style="width: 60px; margin-top: 23px;" onclick="toggleForm()" type="submit" name="formsubmit">
            </form>
        </div>
    </body>
    <script src="src/index.js"></script>
</html>