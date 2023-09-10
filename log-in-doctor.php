<?php
$server = 'localhost';
$user = 'root';
$pass = '';
$db = 'project2';

$conn = mysqli_connect($server,$user,$pass,$db) or die ("unable to connect");


session_start();

?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Doctor log in</title>
        <link rel="stylesheet" href="css/css/all.min.css" />
        <link rel="stylesheet" href="css/log-in-doctor.css" />
    </head>

    <body>
        <div class="main">
            <input type="checkbox" id="chk" aria-hidden="true" />
            <div class="logo">
                <img src="logo.png"/>
            </div>
            <div class="signup">
                <form action="login.php" method="post">
                    <label for="chk" aria-hidden="true">Sign Up</label>
                    <input type="text" name="name" placeholder="User Name" required="" />
                    <input type="email" name="email" placeholder="Email" required="" />
                    <input type="password" name="password" placeholder="Password" required="" />
                    <button type="sumbit" name="signup">Sign Up</button>
                </form>
            </div>

            <div class="login">
                <form action="login.php" method="post">
                    <label for="chk" aria-hidden="true">Login</label>
                    <input type="email" name="email" placeholder="Email" required="" />
                    <input type="password" name="password" placeholder="Password" required="" />
                    <button type="sumbit" name="login">Login</button>
                </form>
            </div>
        </div>
    </body>

</html>