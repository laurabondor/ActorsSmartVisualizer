<?php

@include 'config.php';
@include './user/tokens.php';


session_start();

$_SESSION['previous_page'] = $_SERVER['REQUEST_URI'];

if (!isset($_SESSION['token'])) {
  header('Location: ./user/login_form.php');
  exit();
}


  $token = $_SESSION['token'];

  if (!validateToken($token)) {
      header('Location: ./user/login_form.php');
      exit();
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


    <link rel="stylesheet" href="../static/css/style.css">
    <link rel="stylesheet" href="../static/css/contact.css">
    <style>
        body {
            background-image: url("../static/images/glitterpic.jpg");
        }
    </style>
</head>
<body>

  <div id="navbar"></div>

    <!-- ============== END OF NAVBAR =============== -->
    <section class="contact">
        <div class="form-reponse">
            <p id="my-form-status" style="text-align:center;"></p>
        </div>
        <div class="container contact__container">
            <aside class="contact__aside">
                <div class="aside__image">
                    <img src="../static/images/contact.svg">
                </div>
                <h2>Contact Us</h2>
                <p>
                    Don't hesitate to reach out to us for any questions or suggestions.
                    We want to hear your thoughts!
                </p>
                <ul class="contact__details">
                    <li>
                        <h5>actorsvis@gmail.com</h5>
                    </li>
                    <li>
                        <i class="uil uil-phone"></i>
                        <h5>+0335 234 567</h5>
                    </li> 
                </ul>
                <ul class="contact__socials">
                    <li><a href="https:://facebook.com"><i class="uil uil-facebook"></i></a></li>
                    <li><a href="https:://instagram.com"><i class="uil uil-instagram"></i></a></li>
                    <li><a href="https:://twitter.com"><i class="uil uil-twitter"></i></a></li>
                </ul>
            </aside>

            <form id="my-form" action="https://formspree.io/f/xayzzbdw" method="POST" class="contact__form">
                <div class="form__name">
                    <input type="text" name="First Name" placeholder="First Name" required>
                    <input type="text" name="Last Name" placeholder="Last Name" required>
                </div>
                <input type="email" name="email" placeholder="Your Email Adress" required>
                <textarea type="text" name="message" rows="7" placeholder="Message" required></textarea>
                <button id="my-form-button" type="submit" class="btn btn-primary"> Send Message </button>
            </form>
        </div>
    </section>

    <!-- ============== END OF CONTACT =============== -->

   <?php include('mod/footer.php'); ?>
    
    <script src="../static/main.js"></script>
    <script>
    var form = document.getElementById("my-form");
    
    async function handleSubmit(event) {
      event.preventDefault();
      var status = document.getElementById("my-form-status");
      var data = new FormData(event.target);
      fetch(event.target.action, {
        method: form.method,
        body: data,
        headers: {
            'Accept': 'application/json'
        }
      }).then(response => {
        if (response.ok) {
          status.innerHTML = "Thanks for your submission!";
          form.reset()
        } else {
          response.json().then(data => {
            if (Object.hasOwn(data, 'errors')) {
              status.innerHTML = data["errors"].map(error => error["message"]).join(", ")
            } else {
              status.innerHTML = "Oops! There was a problem submitting your form"
            }
          })
        }
      }).catch(error => {
        status.innerHTML = "Oops! There was a problem submitting your form"
      });
    }
    form.addEventListener("submit", handleSubmit)
</script>
<script>
function loadContent() {
  var width = window.innerWidth;

  if (width > 1023) {
    <?php if(isset($_SESSION['user_name'])){ ?>
      fetch('mod/nav_login.php')
        .then(response => response.text())
        .then(data => {
          document.getElementById('navbar').innerHTML = data;
          attachEventListeners();
        });
    <?php } else { ?>
      fetch('mod/nav_logout.php')
        .then(response => response.text())
        .then(data => {
          document.getElementById('navbar').innerHTML = data;
          attachEventListeners();
        });
    <?php } ?>
  } else {
    fetch('mod/nav_logout.php')
      .then(response => response.text())
      .then(data => {
        document.getElementById('navbar').innerHTML = data;
        attachEventListeners();
      });
  }
}

window.addEventListener('load', loadContent);
window.addEventListener('resize', loadContent);
</script>

</body>
</html> 