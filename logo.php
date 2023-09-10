<?php
$page = 'logindoctor.php';
$sec = "5";
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
    <meta http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo $page?>'">
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Doctor Page</title>
        <link rel="stylesheet" href="css/logo.css" />
        <link rel="stylesheet" href="css/css/all.min.css" />
    </head>

    <body>
        <div class="main">
            <div class="logo">
                <img src="images/logo.png" />
                <h1>MVM</h1>
                <h2>Our vision for Our future</h2>
            </div>
        </div>
    </body>

</html>