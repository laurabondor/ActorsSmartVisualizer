<?php

@include 'config.php';

session_start();

if(isset($_POST['submit'])){

    $_SESSION['info'] = "";
    $password = md5($_POST['password']);
    $cpassword = md5($_POST['cpassword']);

    if($password !== $cpassword){
        $error[] = "Confirm password not matched!";
    }else{
        $code = 0;
        $email = $_SESSION['email']; 
        $table = $_SESSION['table'];
        $update_pass = "UPDATE $table SET code = $code, password = '$password' WHERE email = '$email'";
        $run_query = mysqli_query($conn_user, $update_pass);
        if($run_query){
            $info = "Your password changed. Now you can login with your new password.";
            $_SESSION['info'] = $info;
            header('Location: password_changed.php');
        }else{
            $error[] = "Failed to change your password!";
        }
    }

};
?>

<?php 
$email = $_SESSION['email'];
if($email == false){
  header('Location: login_form.php');
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
                <h3>New Password</h3>
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
                <input type="password" name="password" required placeholder="Create new password">
                <input type="password" name="cpassword" required placeholder="Confirm your password">
                <input type="submit" name="submit" value="Change" class="form-btn">
             </form>    
        </div>
    </header>

    <!-- ============== END OF HEADER =============== -->

    <?php include('../mod/footer_user.php'); ?>
      
    <script src="../../static/main.js"></script>
      
</body>
</html>
