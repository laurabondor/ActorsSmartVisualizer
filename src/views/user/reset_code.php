<?php

@include 'config.php';

session_start();

if(isset($_POST['submit'])){

    $_SESSION['info'] = "";
    $otp_code = mysqli_real_escape_string($conn_user, $_POST['otp']);

    $check_code_user = "SELECT * FROM user_form WHERE code = $otp_code";
    $code_res_user = mysqli_query($conn_user, $check_code_user);

    $check_code_admin = "SELECT * FROM admin_form WHERE code = $otp_code";
    $code_res_admin = mysqli_query($conn_user, $check_code_admin);

    if(mysqli_num_rows($code_res_user) > 0){
        $fetch_data = mysqli_fetch_assoc($code_res_user);
        $email = $fetch_data['email'];
        $_SESSION['email'] = $email;
        $info = "Please create a new password that you don't use on any other site.";
        $_SESSION['info'] = $info;
        header('location: new_password.php');
        exit();
    } else if (mysqli_num_rows($code_res_admin) > 0) {
        $fetch_data = mysqli_fetch_assoc($code_res_admin);
        $email = $fetch_data['email'];
        $_SESSION['email'] = $email;
        $info = "Please create a new password that you don't use on any other site.";
        $_SESSION['info'] = $info;
        header('location: new_password.php');
        exit();
    } else {
        $error[] = "You've entered incorrect code!";
    }


$email = $_SESSION['email'];
if($email == false){
    header('Location: login_form.php');
    exit();
}
}

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actors Smart Visualizer</title>
    <!-- Iconscount cdn -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <!-- Goofle fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../../static/css/style.css">
    <link rel="stylesheet" href="../../static/css/user.css">

    <style>
        body {
            background-image: url("../../static/images/glitterpic.jpg");
        }
    </style>
</head>
<body>

    <?php include('../mod/nav_logout_user.php'); ?>

   <!-- ============== END OF HEADER =============== -->

   <header class="user__forms">
        <div class="container form-container">
            <form action="" method="post">
                <h3>Code Verification</h3>
                <?php 
                    if(isset($_SESSION['info'])){
                        echo '<span class="success-msg">'.$_SESSION['info'].'</span>'; 
                    }
                    ?>
                <?php
                if(isset($error)){
                   foreach($error as $error){
                      echo '<span class="error-msg">'.$error.'</span>';
                   }
                }
                ?>
                <?php
                if(isset($success)){
                   foreach($success as $success){
                      echo '<span class="success-msg">'.$success.'</span>';
                   }
                }
                ?>
                <input type="number" name="otp" required placeholder="Enter code">
                <input type="submit" name="submit" value="Submit" class="form-btn">
             </form>    
        </div>
    </header>

    <!-- ============== END OF HEADER =============== -->

    <?php include('../mod/footer_user.php'); ?>
      
    <script src="../../static/main.js"></script>
      
</body>
</html>
