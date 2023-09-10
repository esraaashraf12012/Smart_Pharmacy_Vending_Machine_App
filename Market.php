<?php
$server = 'localhost';
$user = 'root';
$pass = '';
$db = 'project2';
$conn = mysqli_connect($server,$user,$pass,$db) or die ("unable to connect");

session_start();

$_SESSION['sea']=0;

$_SESSION['count']=0;
$_SESSION['confirm']=0;

	
	$query = "SELECT * FROM product where place is not null";
		
	$run = mysqli_query($conn, $query) or die (mysqli_error($conn));
    $_SESSION['already_added']=0;
 
    if(isset($_POST['Add'])){

	   if ( !empty($_POST['product_id']) ){ 
	 
	   if(isset($_SESSION['cart'])){
		      $item_id =array_column($_SESSION['cart'],"product_id");
			  if(in_array($_POST['product_id'],$item_id)){
				$_SESSION['already_added']=1;
			  }
			  else{
				  $count=count($_SESSION['cart']);
				  $item_array= array(
		         'product_id' =>$_POST['product_id'],
				 'amount' => 1
		        );
		      $_SESSION['cart'][$count]=$item_array;
		       $_SESSION['count']=$count+1;
			  }
			  if ($_SESSION['already_added']==1){
				echo 'medicine is aleardy added in the prescription';
				$_SESSION['already_added']=0;
			  }
	   }
	   else{
		  
		   $item_array= array(
		     'product_id' =>$_POST['product_id'],
			 'amount' => 1
		   );
		   $_SESSION['count']=1;
		   $_SESSION['cart'][0]=$item_array;
	
	   }}
	   unset($_POST['Add']);
	   unset($_POST['dosage']);
	}
	 
	  
	
	if(isset($_POST['search'])){
		if ( !empty($_POST['search_product']) ){ 
	
	      $str=mysqli_real_escape_string($conn,$_POST['search_product']);
		 
		  $query2="SELECT * FROM product where place is not null and name like '%$str%'";
		  $run=mysqli_query($conn,$query2); 
	   
	  $_SESSION['sea']=1;
	}}

	
	



?>
<!doctype html>
<html>

    <head>
        <meta charset="UTF-8" />
        <title>Market</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="css/market.css" />
        <link rel="stylesheet" href="css/css/all.min.css" />
    </head>

    <body>
                <header class="market">
            <nav>
                   <?php if($_SESSION['sea']==1){?>
			         <div class="flex action-bar">
                    <a href="Market.php">
                        <span class="fa-solid fa-circle-chevron-left"></span>
                    </a>
                   <?php }?>
                </div>
                <?php if($_SESSION['sea']==0){?>
                <div class="logo">
                    <h1 style="font-family:'Courier New'">MVM</h1>
                    <p>Welcome to our pharmacy</p>
                </div>
				<?php }?>
				    <a class="logo-img-home" href="#">
                    <img src="images/logo.png" />
                	</a>
					
            </nav>
			<form  action="Market.php" method="post" >
            <div class="search">
			<button type="sumbit" class="search-btn" name='search'>
						   
			 <i class="lass fa-solid fa-magnifying-glass"></i>
			   </button>
                <input type="text" placeholder="Search by name of medicine " name ="search_product">


            </div>
           </form>
        </header>
         <main class="main-market">
         <?php  if ($_SESSION['already_added']==1){
				$_SESSION['already_added']=0;
			  ?>
			<div class="massage">
		   		<p>The medicine is already added</p>
		    </div>
		<?php }?>
            <section>
            <?php while($product=mysqli_fetch_assoc($run)){ ?>
                <form  action="Market.php" method="post" >
                <div class="card" id="item1">
                    <div class="card-container">
                   
                        <div class="card-front">
                            <img src="<?php echo $product['image_dir']; ?>" class= "img"  />
                            <h3 class="title"><?php echo htmlspecialchars($product['name']);?></h3>
							<h5> <?php echo htmlspecialchars($product['amount_box']);?> </h5>
                            <h5>Price: <?php echo htmlspecialchars($product['price']);?> EGP</h5>
                        </div>
                        <input type='hidden' name='product_id' value='<?php echo $product['id']?>'>
                        <div class="card-back">
                            <p> <?php echo htmlspecialchars($product['description']);?> </p>
                        </div>
                    </div>
                    
                    <button type="submit" class="buy" name="Add">Add</button>
                    <!-- <input type="checkbox" id="add" multiple>
                    <label for="add" class="buy">Add to cart</label> -->
                   
                </div>
                
                </div>
                </div>
                </form>
                
               <?php }?>

               
            </section>
        </main>
        <footer class="footer-market">
            <div class="nav-footer-market">
                
                <a href="cart.php" class="control"><i class="far fa-solid fa-cart-plus"></i>Cart <?php if(isset($_SESSION['cart'])){
		        $count=count($_SESSION['cart']);
		        $_SESSION['count']=$count;
	            }echo $_SESSION['count'];?></a>
            </div>
        </footer>
    </body>

</html>