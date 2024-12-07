<?php
include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
    header('location:login.php');
};
if(isset($_GET['logout'])){
    unset($user_id);
    session_destroy();
    header('location:login.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            text-align: center;
        }
        .profile {
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }
        .profile h3 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .btn, .delete-btn {
            display: inline-block;
            padding: 12px 25px;
            margin: 15px 0;
            font-size: 16px;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }
        .btn {
            background-color: #28a745;
            color: #fff;
            border: none;
        }
        .btn:hover {
            background-color: #218838;
        }
        .delete-btn {
            background-color: #dc3545;
            color: #fff;
            border: none;
        }
        .delete-btn:hover {
            background-color: #c82333;
        }
        .profile p {
            font-size: 14px;
            color: #555;
        }
        .profile a {
            color: #000;
            text-decoration: none;
            font-weight: bold;
        }
        .profile p a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }
        .profile a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="profile">
            <?php
                $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$user_id'") or die('query failed');
                if(mysqli_num_rows($select) > 0 ) {
                    $fetch = mysqli_fetch_assoc($select);
                }
                if($fetch['image'] == ''){
                    echo '<img src="images/default-avatar.png">';
                }else{
                echo '<img src="uploaded_img/'.$fetch['image'].'">';
                }
            ?>
            <h3> <?php echo $fetch['name']; ?> </h3>
            <a href="update_profile.php" class="btn">Update Profile</a>
            <a href="home.php?logout=<?php echo $user_id; ?>" class="delete-btn">Logout</a>
            <p>New? <a href="login.php">Login</a> or <a href="register.php">Register</a></p>
        </div>
    </div>

</body>
</html>
