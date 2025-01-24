<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../Styles/successfulRegister.css?v=<?php echo time(); ?>" />
</head>

<body>
  <div class="primary-container">
    <div class="main-container">
      <div>
        <img class="green-tick" src="../resources/images/accept.png" />
        <div class="title-text">Registration Successful!</div>
      </div>
      <div class="body-text">Congratulations! Your account has been successfully created. You can now log in and start
        using our services.</div>
      <button class="login-button" id="login-button">Proceed to Login →</button>
    </div>
  </div>

  <script>
  let btn = document.getElementById('login-button');
  btn.addEventListener('click', function() {
    window.location.href = "login.php";
  });
  </script>

</body>

</html>