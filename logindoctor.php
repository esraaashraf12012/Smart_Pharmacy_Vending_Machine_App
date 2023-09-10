<?php
$server = 'localhost';
$user = 'root';
$pass = '';
$db = 'project2';

$conn = mysqli_connect($server,$user,$pass,$db) or die ("unable to connect");
$_SESSION['not']=0;

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

            <div class="signup">
               
                <form action="login.php" method="post" id="register" class="input-group-2">
                    <label for="chk" aria-hidden="true">Sign Up</label>
                    <input type="text"  placeholder="User Name" required name="name" />
                    <input type="email"  placeholder="Email" required name ="email" />
                    <input type="password"  placeholder="Password" required name="password" />
					<button type="submit" class="submit-btn" name="Register">Sign Up</button>
                    
                </form>
            </div>

            <div class="login">
                <form action="login.php" method="post" id="login" class="input-group-1">
                    <label for="chk" aria-hidden="true">Login</label>
                    <input type="email"  placeholder="Email" required name ="email" />
                    <input type="password"  placeholder="Password" required name ="password" />
                    <button type="submit" class="submit-btn" name="Login">Login</button>
                </form>
            </div>
        </div>
    </body>

</html>