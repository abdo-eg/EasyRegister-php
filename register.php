<?php

include 'config.php';

if(isset($_POST['register'])){

	$name=mysqli_real_escape_string($conn, $_POST['name']);
	$email=mysqli_real_escape_string($conn, $_POST['email']);
	$password=mysqli_real_escape_string($conn, md5($_POST['password']));
	$cpassword=mysqli_real_escape_string($conn, md5($_POST['cpassword']));
	$image=$_FILES['image']['name'];
	$image_size=$_FILES['image']['size'];
	$image_tmp_name=$_FILES['image']['tmp_name'];
	$image_folder='uploaded_img/'.$image;
	
	$select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE email = '$email' AND password = '$password'") or die('query failed');
	
	if(mysqli_num_rows($select)>0){
	    $message[]= 'User already exists';
	}else{
	    if($password !=$cpassword){
	        $message[]= 'Two passwords are not matched!';
	    }elseif($image_size > 2000000){
	        $message[]='Image size is too large';
	    }else{
	    	$insert = mysqli_query($conn, "INSERT INTO `user_form`(name, email, password, image) VALUES('$name','$email','$password', '$image')") or die('query failed');
	    	
	    	if($insert){
	    	    move_uploaded_file($image_tmp_name, $image_folder);
	    	    $message[]='registered successfully!';
	    	    header('location:login.php');
	    	}else{
	    	    $message[]='registeration failed!';
	    	}
	    }    
	}
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #ffffff;
            padding: 20px 40px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
            color: #333;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
            text-align: left;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #5cb85c;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #4cae4c;
        }
        .login-link {
            margin-top: 15px;
            font-size: 14px;
            color: #555;
        }
        .login-link a {
            color: #5cb85c;
            text-decoration: none;
            font-weight: bold;
        }
        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <?php
        if(isset($message)){
        	foreach($message as $message){
        	    echo'<div>'.$message.'</div>';
        	}
        }
        
        
        
        ?>
        <form action="register.php" method="POST" enctype="multipart/form-data">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="cpassword">Confirm Password:</label>
            <input type="password" id="cpassword" name="cpassword" required>

            <label for="image">Upload Profile Image:</label>
            <input type="file" id="image" name="image" accept="image/*" >

            <button type="submit" name="register">Register</button>
        </form>

        <p class="login-link">Already have an account? <a href="login.php">Login now</a></p>
    </div>
</body>
</html>

