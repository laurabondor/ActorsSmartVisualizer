<?php

@include 'config.php';

session_start();

if(isset($_POST['submit'])){

   $email = mysqli_real_escape_string($conn_user, $_POST['email']);
   $select1 = "SELECT * FROM user_form WHERE email = '$email'";
   $result1 = mysqli_query($conn_user, $select1);

   $select2 = "SELECT * FROM admin_form WHERE email = '$email'";
   $result2 = mysqli_query($conn_user, $select2);

   if(mysqli_num_rows($result1) > 0){
      $table = 'user_form';
      $_SESSION['table'] = 'user_form';

   } else if(mysqli_num_rows($result2) > 0){
      $table = 'admin_form';
      $_SESSION['table'] = 'admin_form';

   } else {
      $error[] = 'This email address does not exist!';
   }

   if(!isset($error)){
      $code = rand(999999, 111111);
      $insert_code = "UPDATE $table SET code = $code WHERE email = '$email'";
      $run_query = mysqli_query($conn_user, $insert_code);
      if($run_query){
         $subject = "Password Reset Code";
         $message = "Your password reset code is $code";
         $sender = "From: actorsVis@gmail.com";
         if(mail($email, $subject, $message, $sender)){
            $info = "We've sent a password reset code to your email - $email";
            $_SESSION['info'] = $info;
            $_SESSION['email'] = $email;
            header('location: reset_code.php');
            exit();
         } else {
            $error[] = "Failed while sending code!";
         }
      } else {
         $error[] = "Something went wrong!";
      }
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
                <h3>Forgot Password</h3>
                <span>Enter your email address</span>
                <?php
                if(isset($error)){
                   foreach($error as $err){
                      echo '<span class="error-msg">'.$err.'</span>';
                   }
                }
                ?>
                <?php
                if(isset($success)){
                   foreach($success as $succ){
                      echo '<span class="success-msg">'.$succ.'</span>';
                   }
                }
                ?>
                <input type="email" name="email" required placeholder="Email">
                <input type="submit" name="submit" value="Send Code" class="form-btn">
             </form>    
        </div>
    </header>

    <!-- ============== END OF HEADER =============== -->

    <?php include('../mod/footer_user.php'); ?>
      
    <script src="../../static/main.js"></script>
      
</body>
</html>
