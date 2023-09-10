<?php
$server = 'localhost';
$user = 'root';
$pass = '';
$db = 'project2';
$conn = mysqli_connect($server,$user,$pass,$db) or die ("unable to connect");

session_start();



$_SESSION['confirm_d']=0;
$_SESSION['num']=0;	
	if(isset($_SESSION['cart'])){
		$count=count($_SESSION['cart']);
		$_SESSION['count']=$count+1;
		$product_ids=array_column($_SESSION['cart'],'product_id');
	}
	

	$query = "SELECT * FROM product  ";
		
	$run = mysqli_query($conn, $query) or die (mysqli_error($conn));

    

    if(isset($_POST['remove'])){
		if ( !empty($_POST['product_id']) ){ 
	
	     foreach($_SESSION['cart'] as $key =>$value){
		  if($value['product_id']==$_POST['product_id']){
			   unset($_SESSION['cart'][$key]);
			   $_SESSION['cart'] = array_values(array_filter($_SESSION['cart']));
               $count=count($_SESSION['cart']);
               if ($count==0){
                unset($_SESSION['cart']);
            }
		   }
		  }
	   }
	   unset($_POST['remove']);
	}


	  if(isset($_POST['minis'])){
		if ( !empty($_POST['amount']) ){ 
	       if($_POST['amount']>1){
	     foreach($_SESSION['cart'] as $key =>$value){
		  if($value['product_id']==$_POST['product_id']){
			   $_SESSION['cart'][$key]['amount']= $_POST['amount']-1;
		  }
		   }
		  }
	   }
	   unset($_POST['minis']);
	}


		  if(isset($_POST['plus'])){
		if ( !empty($_POST['amount']) ){ 
		  $id=$_POST['product_id'];
	      $query1 = "SELECT * FROM product where id = '$id' ";
		
	        $run1 = mysqli_query($conn, $query1) or die (mysqli_error($conn));
			if(mysqli_num_rows($run1)== 1){
		    $row1 = mysqli_fetch_assoc($run1);}
	         if($_POST['amount']<$row1['amount_stock']){
	     foreach($_SESSION['cart'] as $key =>$value){
		  if($value['product_id']==$_POST['product_id']){
            $_SESSION['cart'][$key]['amount']= $_POST['amount']+1;
			   
		   }
		  }
	     }
	   }
	   unset($_POST['minis']);
	}


			
    if(isset($_POST['sumbit_code'])){
		if ( !empty($_POST['code']) ){ 
		  $code=$_POST['code'];
          if(isset($_SESSION['codes'])){
            if(in_array($code,$_SESSION['codes'])){}
            else{
          $count_code=count($_SESSION['codes']);
          $_SESSION['codes'][$count_code]=$code;}}
          else{$_SESSION['codes'][0]=$code;}

	      $query1 = "SELECT * FROM prescription_code where code = '$code' ";
		
	        $run1 = mysqli_query($conn, $query1) or die (mysqli_error($conn));
			if(mysqli_num_rows($run1)== 1){
		    $row1 = mysqli_fetch_assoc($run1);}
            $p_id=$row1['p_id'];
            $query2= "SELECT * FROM prescription where p_id = '$p_id' ";
		
	        $run2 = mysqli_query($conn, $query2) or die (mysqli_error($conn));
            while($product=mysqli_fetch_assoc($run2)){
                if(isset($_SESSION['cart'])){
                    
                $item_id =array_column($_SESSION['cart'],"product_id");
                if(in_array($product['product_id'],$item_id)){
                    $_SESSION['already_added']=1;
                  }
                else{
                    $count=count($_SESSION['cart']);
                    $item_array= array(
                   'product_id' =>$product['product_id'],
                   'amount' => $product['amount']
                  );
                $_SESSION['cart'][$count]=$item_array;
                 $_SESSION['count']=$count+1;
                }
                if ($_SESSION['already_added']==1){
                    foreach($_SESSION['cart'] as $key =>$value){
                        if($value['product_id']==$product['product_id']){
                          $_SESSION['cart'][$key]['amount']= $product['amount']+$_SESSION['cart'][$key]['amount'];
                             
                         }
                        }
                  $_SESSION['already_added']=0;
                }
         }
         else{
            
             $item_array= array(
               'product_id' =>$product['product_id'],
               'amount' =>$product['amount']
             );
             $_SESSION['count']=1;
             $_SESSION['cart'][0]=$item_array;
      
         }
            }

	   }
	   unset($_POST['sumbit_code']);
       unset($_POST['code']);
	}
    $str='';
	if(isset($_POST['confirm'])){
		if($_SESSION['confirm']==0){
			
		$_SESSION['confirm']=1;
		$total= $_SESSION['total'];
        $state=0;
		$query1 = "insert into orders(state,total)
		VALUES('$state','$total')";
		$run1 = mysqli_query($conn, $query1) or die (mysqli_error($conn));

		$query2 = "SELECT * FROM orders where state=$state";
		$run2 = mysqli_query($conn, $query2) or die (mysqli_error($conn));
		if(mysqli_num_rows($run2)== 1){
		$row = mysqli_fetch_assoc($run2);}	
		$order_id=$row['id'];
		foreach($_SESSION['cart'] as $key =>$value){
		$amount =$value['amount'];
		$product_id =$value['product_id'];

		$query3 = "insert into cart (order_id,product_id,amount	)
		VALUES('$order_id','$product_id','$amount')";
		$run3 = mysqli_query($conn, $query3) or die (mysqli_error($conn));
        $query4 = "SELECT place FROM product where id=$product_id";
		$run4 = mysqli_query($conn, $query4) or die (mysqli_error($conn));
		if(mysqli_num_rows($run4)== 1){
		$row = mysqli_fetch_assoc($run4);}	
		$place=$row['place'];
        $plac = chr($place +64);
        $str=$str.$plac.$amount.'a'.'0';
    }
         
    }
        $random_file =fopen("data.txt","w");
        fwrite($random_file,$str);
        fclose($random_file);
		unset($_SESSION['cart']);

        header("Location: wait.php");
	}



	  

?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cart</title>
        <link rel="stylesheet" type="text/css" href="css/cart.css" />
        <link rel="stylesheet" href="css/css/all.min.css" />
        <!-- <link href="Market.html"/> -->
    </head>

    <body>
        <header>
            <nav>
                <div class="flex action-bar">
                    <a href="Market.php">
                        <span class="fa-solid fa-circle-chevron-left"></span>
                    </a>
                    <div class="info">
                        <h2>Cart</h2>
                    </div>
                </div>
				<a class="logo-img-home" href="#">
	               <img src="images/logo.png" />
	               </a>
            </nav>
            
</header>
        <main>
		<section>
        <?php if(isset($_SESSION['cart'])){ ?>
            <div class="cart" id="blur">
                <div class="products">
                   <?php 
                   $_SESSION['total']=0;
					while($product=mysqli_fetch_assoc($run)){ 
					foreach($_SESSION['cart'] as $key =>$value){
						  if($product['id']==$value['product_id']){
							$_SESSION['total']=$_SESSION['total']+$_SESSION['cart'][$key ]['amount']*$product['price'];
                            $_SESSION['num']=$_SESSION['num']+$_SESSION['cart'][$key ]['amount'];
				    ?>
			         <div class="card">
					 <div class="card-container">
					<form  action="cart.php" method="post" >

                        <img src="<?php echo $product['image_dir']; ?>" class= "img" />
                        <div class="product-info">
                            <h3 class="product-name"><?php echo htmlspecialchars($product['name']);?></h3>
                            <h4 class="product-price">price:<?php echo htmlspecialchars($product['price']);?> EGP </h4>
                            <div class ="col-md-3 py-5">
							
							<div>
						    <p class="product-quantity"> <button type="sumbit" class="btn bg=light border rounded=circle" name= "minis"><i class="fas fa-minus" name= "minis"></i></button>
							  <input type="text" value="<?php print_r ($_SESSION['cart'][$key ]['amount'])?>" class="form-control w-25 d-inline" required name ="amount"> 
							<button type="sumbit" class="btn bg=light border rounded=circle" name="plus"> <i class="fas fa-plus"  name="plus"></i></button>
							</p>
							</div>
							
						   </div>

                            
                           <input type='hidden' name='product_id' value='<?php echo $product['id']?>'>
                        
                           <button type="sumbit" name='remove' class="product-remove">
                            
                               <i class="fa-solid fa-trash-can" aria-hidden="true"></i>
                                <span  class="remove" ></span>
                            </button>
                        </div>
                    </div>
                   </div>
                    </form>
					<?php }
					} 
					}?>

             
                    <?php }
				      else { ?>
                      <div class="empty">
					   <p>The cart is empty</p>  
                       </div> 
				       <?php }
					?>
                </div>
				
               <?php if(isset($_SESSION['cart'])){?>
                <div class="cart-total">
                    <p>
                        <span>Total Price:</span>
                        <span><?php echo htmlspecialchars($_SESSION['total']);?> EGP</span>
                    </p>

                    <p>
                        <span>Number of Items:</span>
                        <span><?php echo htmlspecialchars($_SESSION['num']);?></span>
                    </p>
                </div>
                <?php }?>
				
            </div>
			</section>
            <form  action="cart.php" method="post"  >
            <div class="cardd" id="pup">
                <i class="las fa-solid fa-circle-check"></i>
                <h3>Thank You </h3>
                <p>Your checkout is done, thank you for using our application</p>
                <button  type='sumbit' class="btn-close" name="confirm">Close</button>
            </div>
            </form>
  

            <div class="code" id="code">
            <form  action="cart.php" method="post"  >
                <i onclick="hide_code(),toggle()" class="farr fa-solid fa-circle-xmark"></i>
                <input type="text" placeholder="Please Enter the code" class="input-code" required name ="code">
                <button type='sumbit' class="btn-close" name="sumbit_code" >Add</button>
            </div>
            </form>
        </main>
        <footer>
            <div class="nav-footer">
                <button onclick="show_pup(),toggle()" class="control"><i
                        class="fa fa-solid fa-money-check-dollar"></i>Checkout</button>
                <button onclick="show_code(),toggle()" class="control"><i class="far fa-regular fa-square-plus"></i> Add
                    the Code</button>
            </div>
        </footer>
        <script>
            function show_pup() {
                document.getElementById('pup').classList.add('open');
            }
            function hide_pup() {
                document.getElementById('pup').classList.remove('open');
            }
            function show_code() {
                document.getElementById('code').classList.add('open')
            }
            function hide_code() {
                document.getElementById('code').classList.remove('open');
            }
            function show_info() {
                document.getElementById('med-info').classList.add('open');
            }
            function hide_info() {
                document.getElementById('med-info').classList.remove('open');
            }
            function toggle() {
                var blur = document.getElementById('blur');
                blur.classList.toggle('active');
            }
        </script>
    </body>

</html>