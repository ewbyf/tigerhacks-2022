<?php
    session_start();
    $inputs = [];
    $error = false;
    $success = false;

    $request_method = strtoupper($_SERVER['REQUEST_METHOD']);
    if ($request_method === 'POST') {
        $license = $_POST['license'];
        $state = $_POST['state'];
        $conn = mysqli_connect('localhost', 'admin', 'pass', 'accounts');
        if (!$conn) {
            echo 'Error:' . mysqli_connect_error();
        }

        $inputs['license'] = $license;
        $inputs['state'] = $state;
        $sql = "SELECT * FROM vehicles WHERE license='$license' AND state='$state'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            if ($row['license'] === $license) {
                $success = true;
                $inputs['user'] = $row['user'];
                $inputs['time'] = $row['time'];
            }
            else {
                $error = true;
            }
        }
        else {
            $error = true;
        }


        $_SESSION['error'] = $error;
        $_SESSION['success'] = $success;
        $_SESSION['inputs'] = $inputs;

        header('Location: /', true, 303);
        exit;
    } 
    else if ($request_method === 'GET') {
        if (isset($_SESSION['error'])) {
            $error = $_SESSION['error'];
            unset($_SESSION['error']);
        }

        if (isset($_SESSION['success'])) {
            $success = $_SESSION['success'];
            unset($_SESSION['success']);
        }

        if (isset($_SESSION['inputs'])) {
            $inputs = $_SESSION['inputs'];
            unset($_SESSION['inputs']);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <script src="src/index.js"></script>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="src/styles.css">
        <link rel="stylesheet" href="../templates/leftmenu.css">
        <title>License Plate Searcher</title>
    </head>
    <?php include('../templates/leftmenu.php'); ?>
    <body>
        <div class="flex-default">
            <div class="flex-center">
                <div>
                    <p class="title">Search for License Plate</p>
                    <form action="index.php" method="post">
                        <div class="search-bar">
                            <input type="text" placeholder="Enter License Plate" name="license" minlength="6" maxlength="6">
                        </div>
                            <select class="statetext" name="state" id="state">
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
                            <option value="ID">ID</option>
                            <option value="IL">IL</option>
                            <option value="IN">IN</option>
                            <option value="IA">IA</option>
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
                            <input class="icon" type="image" src=https://media.discordapp.net/attachments/1001585564950212608/1038547192828403822/submit_button.png alt="Submit feedback">
                    </form>
                    <?php if ($error) : ?>
                        <p class="error">License plate not found</p>
                    <?php endif ?>
                    <?php if ($success) : ?>
                        <p class="success">License plate found!</p>
                        <p class="info">User: <?=$inputs['user'] ?? ''?><br>License: <?=$inputs['license'] ?? ''?><br>State: <?=$inputs['state'] ?? ''?></p>
                        <?php if ($inputs['time'] != "0000-00-00 00:00:00"): ?>
                            <div class="timerwrap">
                                <p class="timer">Time Remaining:</p>
                                <p class="timer" id="clock"></p>
                            </div>
                            <script type="text/javascript">createCountdown(<?=strtotime($inputs['time']);?>);</script>
                        <?php else: ?>
                            <div class="timerwrap">
                                <p class="timer">Not checked in</p>
                            </div>
                       <?php endif ?>
                    <?php endif ?>
                </div>
			</div>
        </div>
    </body>
</html>