<?php
  include("connection.php");

  session_start();

  $email = $password = $captcha = "";
  $email_err = $password_err = $captcha_err = "";

  $err = "";

  if(isset($_POST['login']))
  {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $captcha = $_POST['captcha'];

    if(empty($email))
    {
      $email_err = "Email field cannot be empty. Please provide your email address.";
    }
    else
    {
      if(!preg_match("/^[^\s@]+@[^\s@]+\.[^\s@]+$/",$email))
      {
        $email_err = "Invalid email address: Please enter a valid email in the format 'example@domain.com'.";
      }
      else
      {
        $email_err = "";
      }
    }

    if(empty($password))
    {
      $password_err = "Input cannot be empty. Please enter a valid value.";
    }
    else
    {
      $password_err = "";
    }

    if(empty($captcha))
    {
      $captcha_err = "Input cannot be empty. Please enter a valid value.";
    }
    else
    {
      if(!preg_match('/^[0-9]*$/',$captcha))
      {
        $captcha_err = "Invalid input: Only numbers are allowed.";
      }
      else
      {
        if($captcha == $_SESSION['captcha'])
        {
          $captcha_err = "";
        }
        else
        {
          $captcha_err = "Captcha verification failed. Please enter the correct captcha and try again.";
        }
      }
    }

    if($email_err === "" && $password_err === "" && $captcha_err === "")
    {
      $conn = mysqli_connect("localhost:3306","root","",$dbname);

      if(!$conn)
      {
        die("Unable to connect to database");
      }

      $sql = "SELECT * FROM User WHERE Email = '{$email}' AND Password = '{$password}'";
      $result = mysqli_query($conn,$sql) or die("Unable to login");

      while($data = mysqli_fetch_array($result))
      {
        if($data['Email'] === $email && $data['Password'] === $password)
        {
          $sk = rand(1000,9999);
          $uid = $data['UserId'];
          $_SESSION['uid'][$sk] = $uid;
          header("Location:joinedClassrooms.php?sk=$sk");
          exit();
        }
      }
      $err = "Account not found. Please check your credentials or register for a new account.";
    }
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../Styles/login.css?v=<?php echo time(); ?>">
  <title>Document</title>
</head>

<body>
  <div class="primary-container">
    <form class="form-container" id="form1" action="login.php" method="post">

      <div class="form-title">Login page</div>

      <div class="field-title">Email id</div>
      <input type="text" class="email-tag" id="email-input" name="email" />
      <div class="field-err" id="email-err">*<?php echo $email_err; ?></div>

      <div class="field-title">Password</div>
      <input type="password" class="pass-tag" id="pass-input" name="password" />
      <div class="field-err" id="pass-err">*<?php echo $password_err; ?></div>
      <div class="toggle-visibility" id="toggle-visibility">Show</div>

      <div class="field-title">Captcha</div>
      <img src="captcha.php" class="captcha-img" />
      <input type="text" class="captcha-tag" id="captcha-input" name="captcha" />
      <div class="field-err" id="email-err">*<?php echo $captcha_err; ?></div>

      <div class="err-container" id="err-tag"><?php echo $err; ?></div>

      <input type="submit" class="login-button" id="login-button" name="login" value="Login">

      <div class="register-text">Don't have an account ? <a href="register.php">Create one</a></div>

    </form>
  </div>

  <script>
  let passfield = document.getElementById('pass-input');
  let togglediv = document.getElementById('toggle-visibility');

  togglediv.addEventListener('click', function() {
    if (passfield.type == 'password') {
      passfield.type = 'text';
      togglediv.innerText = "Hide";
    } else {
      passfield.type = 'password';
      togglediv.innerText = "Show";
    }
  });
  </script>

</body>

</html>