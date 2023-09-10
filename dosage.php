<?php
$server = 'localhost';
$user = 'root';
$pass = '';
$db = 'project2';
$conn = mysqli_connect($server,$user,$pass,$db) or die ("unable to connect");

session_start();


if(isset($_POST['confirm'])){
    if($_SESSION['confirm_d']==0){
        
    $_SESSION['confirm_d']=1;

    unset($_SESSION['codes']);
        
   
        header("Location: Market.php");
    

    
}}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dosage</title>
    <link rel="stylesheet" type="text/css" href="css/dosage.css" />
    <link rel="stylesheet" href="css/css/all.min.css" />
</head>
<body>
    <header>
        <nav>
            <div class="flex action-bar">
                <div class="info">
                    <h2>Dosage</h2>
                </div>
            </div>
            <a class="logo-img-home" href="#">
	               <img src="images/logo.png" />
	               </a>
        </nav>
    </header>
    <main>
        <div class="cart" id="blur">
            <table>

                <tbody>
                    <?php 
                        foreach($_SESSION['codes'] as $code){
                            
                        $query1 = "SELECT * FROM prescription_code where code = '$code' ";
                        $run1 = mysqli_query($conn, $query1) or die (mysqli_error($conn));
                        if(mysqli_num_rows($run1)== 1){
                        $row1 = mysqli_fetch_assoc($run1);}
                        $p_id=$row1['p_id'];
						$p_time=$row1['time'];
						$d_id=$row1['doctor_id'];
                        $query2= "SELECT * FROM prescription where p_id = '$p_id' ";
                        $run2 = mysqli_query($conn, $query2) or die (mysqli_error($conn));
                        $query4= "SELECT * FROM user where id = '$d_id' ";
                        $run4 = mysqli_query($conn, $query4) or die (mysqli_error($conn));
						if(mysqli_num_rows($run4)== 1){
                        $row4 = mysqli_fetch_assoc($run4);}
						$d_name=$row4['name'];
                        ?>
                    <tr>
                        <td class="name" >
						
						code: <?php  echo htmlspecialchars($code); ?> <br> 
						Date: <?php  echo htmlspecialchars($p_time); ?><br>
						doctor: <?php  echo htmlspecialchars($d_name); ?>
						
						</td>
                        <?php while($product=mysqli_fetch_assoc($run2)){
                            $product_id=$product['product_id'];
                            $query3 = "SELECT * FROM product where id = $product_id";
		
                            $run3 = mysqli_query($conn, $query3) or die (mysqli_error($conn));
                            if(mysqli_num_rows($run3)== 1){
                                $row3 = mysqli_fetch_assoc($run3);}
                            ?>
                        <td class="dosage-for-child">
                            <p><?php  echo htmlspecialchars($row3['name']);?></p>
                            <?php  echo htmlspecialchars($product['dose']);?>
                        </td>
                        <?php }?>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>
        <div class="cardd" id="pup">
        <form  action="dosage.php" method="post"  >
            <i class="las fa-solid fa-circle-check"></i>
            <h3>Thank You </h3>
            <p>Your checkout is done, thank you for using our application</p>
            <button type='sumbit' class="btn-close" name="confirm">Close</button>
        </div>
      </form>
    </main>
    <footer>
        <div class="nav-footer">
            <button onclick="show_pup(),toggle()" class="control">
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
    </script>
</body>
    
</html>