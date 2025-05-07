<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pagina di accesso</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
  <link rel="stylesheet" href="Css/accedi.css">
</head>
<body>
  <div class="wrapper">
    <div class="title"><span>Cambia Password</span></div>


    <form id="login-form" action="php/cambia_passwordDB.php?token=<?php echo $_GET['token']; ?>" method="POST" onsubmit="return validateForm()">
      <div class="row">   
        <i class="fas fa-user"></i>
        <input type="password" name="password" placeholder="Nuova Password" required />
      </div>

      <div class="row">   
        <i class="fas fa-user"></i>
        <input type="password" name="Rpassword" placeholder="Ripeti Password" required />
      </div>

      <div class="row button">
        <input type="submit" value="Cambia Password" />
      </div>

    </form>


  </div>
  <script src="Js/accedi.js"></script>
</body>
</html>
