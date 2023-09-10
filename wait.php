<?php
$page = $_SERVER['PHP_SELF'];
$sec = "5";
$server = 'localhost';
$user = 'root';
$pass = '';
$db = 'project2';
$conn = mysqli_connect($server,$user,$pass,$db) or die ("unable to connect");

session_start();


$httpcode = file_get_contents("http://192.168.1.125:100/project2_2/data.txt");
if($httpcode==1){

echo "success";
$query1 ="UPDATE orders SET state = 1 WHERE state=0 ";
  
$run1 = mysqli_query($conn, $query1) or die (mysqli_error($conn));
if(isset($_SESSION['codes'])){
    header("Location: dosage.php");
}
else{
 
    header("Location: Market.php");
}

}

?>
<!DOCTYPE html>

<html lang="en">

    <head>
    <meta http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo $page?>'">
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Loading....</title>
        <link rel="stylesheet" type="text/css" href="css/wait.css" />
        <link rel="stylesheet" href="css/css/all.min.css" />
    </head>

    <body>
        <div class="container">

            <header>
                
                <nav>
                    <div class="flex action-bar">
                        <div class="info">
                            <h2>Dosage</h2>
                        </div>
                    </div>
                </nav>
            </header>

            <main>
            </main>

            <footer>
                <div class="nav-footer">
                    <div class="control"><i class="fa fa-solid fa-clipboard-check"></i>
                        Confirm</div>
                </div>
            </footer>

        </div>

        <div class="cardd">
            <div class="loading"></div>
            <h3>LOADING.....</h3>
        </div>
        
    </body>

</html>