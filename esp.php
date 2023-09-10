<?php
$page = $_SERVER['PHP_SELF'];
$sec = "10";
$httpcode =0;
$httpcode = file_get_contents("http://192.168.1.125:100/project2_2/data.txt");

if(!$httpcode == false){
    echo $httpcode ;
    
if (isset($_GET['api'])) {
    $apiToken = $_GET['api'];
    if ($apiToken == "123456") {
       $random_file =fopen("data.txt","w");
       $str=$_GET['x'];
       fwrite($random_file,$str);
       fclose($random_file);

    }
}

}
else{
	
	echo "no massage";
	
}

?>
<html>
    <head>
    <meta http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo $page?>'">
    </head>
    <body>

    </body>
</html>