<?php
$server = 'localhost';
$user = 'root';
$pass = '';
$db = 'project2';
$conn = mysqli_connect($server,$user,$pass,$db) or die ("unable to connect");

session_start();

    if(isset($_SESSION['EMAIL']) && isset($_SESSION['ID'])){

	if(isset($_SESSION['prescription'])){
		$count=count($_SESSION['prescription']);
		$_SESSION['count']=$count+1;
		$product_ids=array_column($_SESSION['prescription'],'product_id');
	}
	$ID =$_SESSION['ID'];

	$query = "SELECT * FROM product  ";
		
	$run = mysqli_query($conn, $query) or die (mysqli_error($conn));

    

    if(isset($_POST['remove'])){
		if ( !empty($_POST['product_id']) ){ 
	
	     foreach($_SESSION['prescription'] as $key =>$value){
		  if($value['product_id']==$_POST['product_id']){
			   unset($_SESSION['prescription'][$key]);
			  
			  $_SESSION['prescription'] = array_values(array_filter($_SESSION['prescription']));
			  $count=count($_SESSION['prescription']);
	           if ($count==0){
	           unset($_SESSION['prescription']);}
		   }
		  }
	   }
	   unset($_POST['remove']);
	}

	  if(isset($_POST['minis'])){//
		if ( !empty($_POST['amount']) ){ 
	       if($_POST['amount']>1){
	     foreach($_SESSION['prescription'] as $key =>$value){
		  if($value['product_id']==$_POST['product_id']){
			   $_SESSION['prescription'][$key]['amount']= $_POST['amount']-1;
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
	     foreach($_SESSION['prescription'] as $key =>$value){
		  if($value['product_id']==$_POST['product_id']){
            $_SESSION['prescription'][$key]['amount']= $_POST['amount']+1;
			   
		   }
		  }
	     }
	   }
	   unset($_POST['plus']);
	}
			  if(isset($_POST['dose'])){
		if ( !empty($_POST['dosage']) ){ 
		
	         
	     foreach($_SESSION['prescription'] as $key =>$value){
		  if($value['product_id']==$_POST['product_id']){
            $_SESSION['prescription'][$key]['dosage']= $_POST['dosage'];
			   
		   
		  }
	     }
	   }
	   unset($_POST['dose']);
	}
	
	if(isset($_POST['confirm'])){
		if($_SESSION['confirm']==0){
			
		$_SESSION['confirm']=1;
		$code= $_SESSION['code'];
		$query1 = "insert into prescription_code(code,doctor_id)
		VALUES('$code','$ID')";
		$run1 = mysqli_query($conn, $query1) or die (mysqli_error($conn));

		$query2 = "SELECT * FROM prescription_code where code='$code'";
		$run2 = mysqli_query($conn, $query2) or die (mysqli_error($conn));
		if(mysqli_num_rows($run2)== 1){
		$row = mysqli_fetch_assoc($run2);}	
		$p_id=$row['p_id'];
		foreach($_SESSION['prescription'] as $key =>$value){
		$dosage = $value['dosage'];
		$amount =$value['amount'];
		$product_id =$value['product_id'];
		$query3 = "insert into prescription(p_id,product_id,amount,dose)
		VALUES('$p_id','$product_id','$amount','$dosage')";
		$run3 = mysqli_query($conn, $query3) or die (mysqli_error($conn));}}
		unset($_SESSION['prescription']);
		$_SESSION['code']=substr(md5(time()),0,6); 
		header("Location: doctor-page.php");
	}



	  } 

?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>presscription</title>
        <link rel="stylesheet" href="css/prescription.css" />
        <link rel="stylesheet" href="css/css/all.min.css" />
    </head>

    <body>
        <header>
            <nav>
                <div class="flex action-bar">
                    <a href="doctor-page.php">
                        <span class="fa-solid fa-circle-chevron-left"></span>
                    </a>
                    <div class="info">
                        <h2>Prescription</h2>
                    </div>
				
					</div>

                  <a class="logo-img-home" href="#">
	               <img src="images/logo.png" />
	               </a>

               
            
            </nav>
        </header>
         <main>
		 <section>
		 <div class="cart" id="blur">
		    <?php if(isset($_SESSION['prescription'])){ ?>
            
                
                    <?php 
					while($product=mysqli_fetch_assoc($run)){ 
					foreach($_SESSION['prescription'] as $key =>$value){
						  if($product['id']==$value['product_id']){
							
					?>
					 <div class="card">
					 <div class="card-container">
					<form  action="prescription.php" method="post" >
                   
                    
                        <img src="<?php echo $product['image_dir']; ?>"/>
                        <div class="product-info">
                            <h3 class="product-name"><?php echo htmlspecialchars($product['name']);?></h3>
							<div class ="col-md-3 py-5">
							
							<div>
						    <p class="product-quantity"> <button type="sumbit" class="btn bg=light border rounded=circle" name= "minis"><i class="fas fa-minus" name= "minis"></i></button>
							  <input type="text" value="<?php print_r ($_SESSION['prescription'][$key ]['amount'])?>" class="form-control w-25 d-inline" required name ="amount"> 
							<button type="sumbit" class="btn bg=light border rounded=circle" name="plus"> <i class="fas fa-plus"  name="plus"></i></button>
							</p>
							</div>
							
						   </div>
							<div class="dosage" >
                           <b>Dosage: </b>
						   <pr></pr>
						   <input type="text" class="dosage input" value="<?php print_r ($_SESSION['prescription'][$key ]['dosage'])?>"  required name ="dosage">
						  
						   <button type="sumbit" class="btn btn-light" name='dose'>
						   
                               <i class="fa-solid fa-check"></i>
                            </button>
						  </div>
						   
						   <input type='hidden' name='product_id' value='<?php echo $product['id']?>'>
                        
                           <button type="sumbit" name='remove' class="product-remove">
                            
                               <i class="fa-solid fa-trash-can" aria-hidden="true"></i>
                                <span  class="remove" >Remove</span>
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
							<p>The prescription is empty</p> 
							</div> 
						<?php } ?>
					
            
          </div>
		  </section>
		  <form  action="prescription.php" method="post"  >
            <div class="cardd" id="pup">
                <i class="las fa-solid fa-circle-check"></i>
                <h3>prescription code: <?php echo $_SESSION['code']?></h3>
                <p>Your prescription is done, thank you for using our application</p>
                <button type='sumbit' class="btn-close" name="confirm" >Close</button>

            </div>
			</form>

        </main>
        <footer>
		
            <div class="nav-footer">
                <button onclick="show_pup(),toggle()"  class="control">
                    <i class="fa fa-solid fa-clipboard-check"></i>Confirm</button>
            </div>
			
				


				
        </footer>
        <script>
            function show_pup() {
                document.getElementById('pup').classList.add('open');
            }
            function hide_pup() {
                document.getElementById('pup').classList.remove('open');
            }
            function toggle() {
                var blur = document.getElementById('blur');
                blur.classList.toggle('active');
            }
            function show_info() {
                document.getElementById('med-info').classList.add('open');
            }
            function hide_info() {
                document.getElementById('med-info').classList.remove('open');
            }
        </script>
    </body>

</html>