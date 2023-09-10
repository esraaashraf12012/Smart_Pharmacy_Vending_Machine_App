<?php
$server = 'localhost';
$user = 'root';
$pass = '';
$db = 'project2';

$conn = mysqli_connect($server,$user,$pass,$db) or die ("unable to connect");

session_start();


if(isset($_POST['confirm'])){
	
	if (!empty($_POST['name']) ){
		
		$filename = $_FILES["file"]["name"];
        $tempname = $_FILES["file"]["tmp_name"];  
        $folder = "images/".$filename;
        if (move_uploaded_file($tempname, $folder)) {

            $image_dir=$folder;

        }
	
		
		
	   
	   $name=$_POST['name'];
	   $description=$_POST['description'];
	   $amount_box=$_POST['amount_box'];
	   $amount_stock=$_POST['amount_stock'];	
	   $price=$_POST['price'];
       $place=$_POST['place'];	
       $expiry_date=$_POST['expiry_date'];
	   
	   
	   if($place==0){
       $query3 = "Insert into product(name,description,amount_box,amount_stock,price,expiry_date,image_dir)
	   VALUES('$name','$description','$amount_box',$amount_stock,'$price','$expiry_date','$image_dir')"; }

         
		 else{      
     $query3 = "Insert into product(name,description,amount_box,amount_stock,price,place,expiry_date,image_dir)
		VALUES('$name','$description','$amount_box',$amount_stock,'$price','$place','$expiry_date','$image_dir')"; }
		$run3 = mysqli_query($conn, $query3) or die (mysqli_error($conn));
		
		  header("Location: admin-main.php");
    }
}



?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Product Add</title>
        <link rel="stylesheet" type="text/css" href="css/admin-add.css" />
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
                        <h3>&emsp; &emsp; &ensp;Add Product </h3>
                    </div>
                </div>
				   <a class="logo-img-home" href="#">
	               <img src="images/logo.png" />
	               </a>
            </nav>
        </header>
        <main>
		<section>
		
            <div class="cart" id='blur'>

                <div class="products">

                  <form enctype="multipart/form-data" action="admin-add.php" method="post" >
                    <div class="card">
                        <div class="card-container">
                            <div class="pro-img">
							     
                                <img src="images/white.jpg" alt="" id="file-ip-1-preview"  class="img"/>
                                <div class="round">
                                    <input type="file" id="file-ip-1" accept="image/*"  name ="file"  onchange="showPreview(event);  ">
                                    <i class="fa-solid fa-circle-plus" style=" color:#fff;"></i>
                                </div>
                            </div>
                            
                        </div>
                        <div class="card-container">
                            <div class="dosage">
                                <b>name: </b><input type="text"   name="name"/>
                            </div>
                        </div>
                        <div class="card-container">
                            <div class="dosage">
                                <b>description: </b>
								<textarea rows = "5" cols = "43"  name = "description" > </textarea>
                            </div>
                        </div>
                        <div class="card-container">
                            <div class="dosage">
                               <b>amount per box: </b> <input type="text"  name="amount_box"/>
                            </div>
                        </div>
                        <div class="card-container">
                            <div class="dosage">
                               <b>amount in stock: </b> <input type="text"  name="amount_stock" />
                            </div>
                        </div>
                        <div class="card-container">
                            <div class="dosage">
                               <b>price: </b> <input type="text"  name="price"/>
                            </div>
                        </div>
                        <div class="card-container">
                            <div class="dosage">
                                <b>place: </b><input type="text"  name="place" />
                            </div>
                        </div>
                        <div class="card-container">
                            <div class="dosage">
                                <b>Expiration date: </b>
                                <input type="date"  name="expiry_date"/>
                            </div>
                        </div>

                    </div>
					
                </div>
            </div>
			</section>
            <div class="cardd" id="pup">
                <i class="las fa-solid fa-circle-check"></i>
                <h3>Done </h3>
                <p>The product has been Added</p>
                
				<button  type='sumbit' class="btn-close" name="confirm">Close</button>
            </div>
			</form>
        </main>

        <footer>
        </footer>
        <div class="footer">
            <div class="nav-footer">
                <a onclick="show_pup(),toggle()" class="control"><i class="far fa-solid fa-square-check"></i>
                    Submit</a>
            </div>
        </div>
    </body>

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
		
	    function showPreview(event){
            if(event.target.files.length > 0){
			var src = URL.createObjectURL(event.target.files[0]);
			var preview = document.getElementById("file-ip-1-preview");
			preview.src = src;
			preview.style.display = "block";
			}
		}
    </script>

</html>