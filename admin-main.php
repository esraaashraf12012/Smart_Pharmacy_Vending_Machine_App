<?php
$server = 'localhost';
$user = 'root';
$pass = '';
$db = 'project2';
$conn = mysqli_connect($server,$user,$pass,$db) or die ("unable to connect");

session_start();



	
	$query = "SELECT * FROM product ";
		
	$run = mysqli_query($conn, $query) or die (mysqli_error($conn));
    
    unset($_SESSION['nots']);
    $_SESSION['not']=0;
    $_SESSION['out']=0;
    $_SESSION['expir']=0;
    while($product=mysqli_fetch_assoc($run)){
        if(date("Y-m-d") >= $product['expiry_date']){

            $_SESSION['nots'][$_SESSION['not']]="product " .$product['name']." has expired since ".$product['expiry_date'];
            $_SESSION['not']=$_SESSION['not']+1;
            $_SESSION['expir']=$_SESSION['expir']+1;
            
        }
 
    }
    $query = "SELECT * FROM product ";
		
	$run = mysqli_query($conn, $query) or die (mysqli_error($conn));

    while($product=mysqli_fetch_assoc($run)){
        if($product['amount_stock']==0){

            $_SESSION['nots'][$_SESSION['not']]="product stock " .$product['name']." is empty";
            $_SESSION['not']=$_SESSION['not']+1;
            $_SESSION['out']=$_SESSION['out']+1;
        }
 
    }

	  
    $query = "SELECT * FROM product ";
		
	$run = mysqli_query($conn, $query) or die (mysqli_error($conn));

	
	



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/admin-main.css" />
    <link rel="stylesheet" href="css/css/all.min.css" />
    <title>Main Admin Page</title>
</head>

<body>
    <header>
        <nav>
        <div class="flex action-bar">
                <div class="info">
                    <h2>MVM</h2>
                    <p>pharmacy</p>
                </div>
 
            </div>
            <a class="notification" href="notification.php">
                <div class="counter">
                    <div class="num"><?php echo htmlspecialchars( $_SESSION['not']);?></div>
                </div>
                <i class="fo fa-solid fa-bell"></i>
            </a>
        </nav>
    </header>
    <main>
        <div class="cart" id="blur">
            <!-- <form> -->
                <div class="products">
				<?php while($product=mysqli_fetch_assoc($run)){ ?>
				<form  action="admin-edit.php" method="post" >
                    <div class="product">
                        <img src="<?php echo $product['image_dir']; ?>" class= "img"/>
                        <div class="product-info">
                            <h4 class="product-name"><?php echo htmlspecialchars($product['name']);?></h4>
                            <p>box: <?php echo htmlspecialchars($product['amount_box']);?> </p>
                            <p>No.of stocks: <?php echo htmlspecialchars($product['amount_stock']);?></p>
                            <p>Price: <?php echo htmlspecialchars($product['price']);?> EGP</p>
                            <p>Place:<?php echo htmlspecialchars($product['place']);?></p>
                            <p class="exp">Exp:<?php echo htmlspecialchars($product['expiry_date']);?></p>
							<p><br> </p>
							<input type='hidden' name='product_id' value='<?php echo $product['id']?>'>
                            <div class="product-remove" >
                                
                                <button type="sumbit" class="remove" name="edit">Edit</button>
                            </div>
                        </div>
						</form>
                           
                            
                        
                    </div>
					<?php }?>
                </div>
            <!-- </form> -->
        </div>
		
   
            
    </main>
    <footer>
        <div class="nav-footer">
            <a href="admin-add.php" class="control"><i class="far fa-regular fa-square-plus"></i>
                Add New Product</a>
        </div>
    </footer>

</body>

</html>