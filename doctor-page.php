<?php
$server = 'localhost';
$user = 'root';
$pass = '';
$db = 'project2';
$conn = mysqli_connect($server,$user,$pass,$db) or die ("unable to connect");

session_start();

$_SESSION['sea']=0;

$_SESSION['count']=0;
if(isset($_SESSION['EMAIL']) && isset($_SESSION['ID'])){
	$_SESSION['confirm']=0;
	$ID =$_SESSION['ID'];
	
	$query = "SELECT * FROM product where place is not null";
		
	$run = mysqli_query($conn, $query) or die (mysqli_error($conn));
    $_SESSION['already_added']=0;
 
    if(isset($_POST['Add'])){
		$dosage = $_POST['dosage'];
		$product_id = $_POST['product_id'];
	   if ( !empty($_POST['dosage']) ){ 
	 
	   if(isset($_SESSION['prescription'])){
		      $item_id =array_column($_SESSION['prescription'],"product_id");
			  if(in_array($_POST['product_id'],$item_id)){
				$_SESSION['already_added']=1;
			  }
			  else{
				  $count=count($_SESSION['prescription']);
				  $item_array= array(
		         'product_id' =>$_POST['product_id'],
			     'dosage' =>$_POST['dosage'],
				 'amount' => 1
		        );
		      $_SESSION['prescription'][$count]=$item_array;
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
			 'dosage' =>$_POST['dosage'],
			 'amount' => 1
		   );
		   $_SESSION['count']=1;
		   $_SESSION['prescription'][0]=$item_array;
	
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

	
	
}


?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Doctor Page</title>
        <link rel="stylesheet" href="css/doctor-page.css" />
        <link rel="stylesheet" href="css/css/all.min.css" />
    </head>

        <body>
        <header>
            <nav>

				<?php if($_SESSION['sea']==1){?>
				<div class="flex action-bar">
                    <a href="doctor-page.php">
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
			<form  action="doctor-page.php" method="post" >
            <div class="search">
				<button type="sumbit" class="search-btn" name='search'>
						   <i class="lass fa-solid fa-magnifying-glass"></i> </button>
                <input type="text" placeholder="Search by name of medicine " name ="search_product">
			</div>
           </form>
		   
        </header>
        <main>
            <section>
                <!-- CARD - 1 -->
				<?php while($product=mysqli_fetch_assoc($run)){ ?>
                <div class="card">
                    <div class="card-container">
					    <form  action="doctor-page.php" method="post" >
                        <img src="<?php echo $product['image_dir']; ?>" class= "img"  />
                        <h3><?php echo htmlspecialchars($product['name']);?></h3>

                        <div class="dosage">
                            <input type="text" placeholder="dosage"  name="dosage"/>
                        </div>
						<input type='hidden' name='product_id' value='<?php echo $product['id']?>'>
                    </div>
                    <button type="submit" class="buy" name="Add">Add</button>
					</form>
                </div>
              
               <?php }?>
               

            </section>
        </main>
        <footer>

            <div class="nav-footer">
                <a href="prescription.php" class="control"><i class="far fa-solid fa-capsules"></i>
					Prescription       
				</a>
				<div class="count">
					<div class="num-count">
						<?php if(isset($_SESSION['prescription'])){
						$count=count($_SESSION['prescription']);
						$_SESSION['count']=$count;
						}echo $_SESSION['count'];?>
					</div>
				</div>
            </div>

        </footer>
    </body>

</html>