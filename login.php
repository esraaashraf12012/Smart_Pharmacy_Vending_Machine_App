<?php
$server = 'localhost';
$user = 'root';
$pass = '';
$db = 'project2';

$conn = mysqli_connect($server,$user,$pass,$db) or die ("unable to connect");

session_start();

if(isset($_POST['Register'])){
	
	if (!empty($_POST['name']) || !empty($_POST['email']) || !empty($_POST['password'] )){
		

		
		$name = $_POST['name'];
		$email = $_POST['email'];
		$password = $_POST['password'];

	    
		$query = "insert into user(type,email,name,password )
		VALUES('DOCTOR','$email','$name','$password')";
		
		$run = mysqli_query($conn, $query) or die (mysqli_error($conn));
        
		if($run){
			$_SESSION['success'] = "register successed";
			header("Location: logindoctor.php");
		}
		else{
			$_SESSION['error'] = "register failed";
			header("Location: logindoctor.php");
		}
	}
}



if(isset($_POST['Login'])){
	
	if (!empty($_POST['email']) || !empty($_POST['password']) ){ 
		
		function validate($data) {
			$data =trim($data);
			$data =stripslashes($data);
			$data =htmlspecialchars($data);
			return $data;
		}
			
	
		$email =validate( $_POST['email']);
		$password = validate($_POST['password']);
		
	
		$query = "SELECT * FROM user WHERE email='$email' AND password='$password'";
		
		$run = mysqli_query($conn, $query) or die (mysqli_error($conn));
		
		if(mysqli_num_rows($run)== 1){
			$row = mysqli_fetch_assoc($run);
			if($row['email']== $email && $row['password']==$password){
			echo "login successful";
			session_unset();
			$_SESSION['EMAIL']=$row['email'];
			$_SESSION['NAME']=$row['name'];
			$_SESSION['ID']=$row['id'];
			
			
			
			$_SESSION['code']=substr(md5(time()),0,6); 
			if($row['type']=="admin"){
				header("Location: admin-main.php");
			}
			else{
			header("Location: doctor-page.php");
			}
		}
	}
		else{
			$_SESSION['error'] = "login failed : Wrong email or passward";
			header("Location: logindoctor.php");
			
			
		}
	}
}

?>