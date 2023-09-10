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
        <title>Notifications</title>
        <link rel="stylesheet" href="css/notification.css" />
        <link rel="stylesheet" href="css/css/all.min.css" />
    </head>

    <body>
        <header>
            <nav>
                <div class="flex action-bar">
                    <a href="admin-main.php">
                        <span class="fa-solid fa-circle-chevron-left"></span>
                    </a>
                    <div class="info">
                        <h2>Notifications</h2>
                    </div>
					<div class="logo-img-home" >
                    	<img src="images/logo.png" />
               		</div>
                </div>
            </nav>
            
        </header>
        <main>
            <div class="cart" id="blur">
                <div class="products">
                        <?php if($_SESSION['not']>0) {
                            $counter=0;
                            while($counter<$_SESSION['not']){ 
                             while($counter<$_SESSION['expir']){
                                
                                    ?>
                     <div class="product">
                        <div class="product-info">
                            <div class="exp-date">
                                <i class="fo fa-solid fa-calendar-xmark">
                                    <span class="name">Expire Date</span>
                                </i>
                                <p class="content"><?php echo htmlspecialchars( $_SESSION['nots'][$counter]);?></p>
                            </div>
                        </div>
                        </div>
                        <?php  $counter=$counter+1;} 
                         while($counter<$_SESSION['expir']+$_SESSION['out']){?>
                        <div class="product">
                        <div class="product-info">
                            <div class="stock">
                                <i class="fo fa-solid fa-bullhorn">
                                    <span class="name">Stock-Out</span>
                                </i>
                                <p class="content"><?php echo htmlspecialchars( $_SESSION['nots'][$counter]);?></p>
                            </div>
                        </div>

                    </div>
<?php $counter=$counter+1;}
}
}
?>
            


                </div>
            </div>
        </main>
    </body>

</html>