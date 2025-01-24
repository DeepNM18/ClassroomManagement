<?php
  include("connection.php");

  $fname = $email = $password = $profilepic = $dob = "";
  $gender = "Male"; 
  $fname_err = $email_err = $password_err = $profilepic_err = $dob_err = $gender_err = "";

  $err = "";

  if(isset(($_POST['register'])))
  {
    $fname = $_POST['fname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $profilepic = $_FILES['profilepic']['name'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];

    if(empty($fname))
    {
      $fname_err = "This field cannot be empty. Please enter a valid value.";
    }
    else
    {
      if(!preg_match("/^[a-zA-Z\s]*$/",$fname))
      {
        $fname_err = "Invalid input: Only letters and spaces are allowed.";
      }
      else
      {
        $fname_err = "";
      }
    }

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
      if(!preg_match("/^[a-zA-Z\s0-9_-]*$/",$password))
      {
        $password_err = "Invalid input: Only letters, numbers, spaces, underscores, and hyphens are allowed.";
      }
      else
      {
        $password_err = "";
      }
    }

    if(empty($profilepic))
    {
      $profilepic_err = "Profile picture is required. Please upload a valid image to proceed.";
    }
    else
    {
      $profilepic_err = "";
    }

    if(empty($dob))
    {
      $dob_err = "Date of Birth is required. Please provide a valid date of birth.";
    }
    else
    {
      $dob_err = "";
    }

    // echo $fname;
    // echo $email;
    // echo $password;
    // echo $profilepic;
    // echo $dob;
    // echo $gender;

    if($fname_err === "" && $email_err === "" && $password_err === "" && $profilepic_err === "" && $dob_err === "" && $gender_err === "")
    {
      $target_dir = "../resources/profilepics/";
      if(isset($_FILES['profilepic']['name']))
      {
        $temp_file = $target_dir . basename($_FILES['profilepic']['name']);
        $imageFileType = strtolower(pathinfo($temp_file,PATHINFO_EXTENSION));

        if($imageFileType === "jpg" || $imageFileType === "jpeg" || $imageFileType === "png")
        {
          $target_file = $target_dir . uniqid() . '.' . $imageFileType;
          if(move_uploaded_file($_FILES['profilepic']['tmp_name'],$target_file))
          {
            $profilepic = $target_file;

            $conn = mysqli_connect("localhost:3306","root","",$dbname);
            if(!$conn)
            {
              die("Unable to connect to database");
            }
            
            $sql = "INSERT INTO User (FUllname,Email,Password,ProfilePicURL,DOB,Gender,CreateDate) VALUES ('{$fname}','{$email}','{$password}','{$profilepic}','{$dob}','{$gender}',SYSDATE())";
            if(mysqli_query($conn,$sql))
            {
              header("Location:successfulRegister.php");
              exit();
            }
          }
          else
          {
            $err = "Profile picture upload failed. Please try again with a valid image file.";
          }
        }
        else
        {
          $profilepic_err = "Invalid file type: Only JPG, JPEG, and PNG files are allowed. Please upload a valid image file.";
        }
      }
      else
      {
        $err = "Registration failed. Please try again later or check your details for accuracy.";
      }
    }
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../Styles/register.css?v=<?php echo time(); ?>">
  <title>Document</title>
</head>

<body>
  <div class="primary-container">
    <form class="form-container" id="form1" action="register.php" method="post" enctype="multipart/form-data">

      <div class="form-title">Registration page</div>

      <div class="middle-div">

        <div class="left-div">

          <div class="field-title">Full Name</div>
          <input type="text" class="fname-tag" id="fname-input" name="fname" />
          <div class="field-err" id="fname-err">*<?php echo $fname_err; ?></div>

          <div class="field-title">Email id</div>
          <input type="text" class="email-tag" id="email-input" name="email" />
          <div class="field-err" id="email-err">*<?php echo $email_err; ?></div>

          <div class="field-title">Password</div>
          <input type="password" class="pass-tag" id="pass-input" name="password" />
          <div class="field-err" id="pass-err">*<?php echo $password_err; ?></div>
          <div class="toggle-visibility" id="toggle-visibility">Show</div>

        </div>

        <div class="right-div">

          <div class="field-title">Select Profile Pic</div>
          <input type="file" class="profile-tag" id="profile-input" name="profilepic" />
          <div class="field-err" id="profile-err">*<?php echo $profilepic_err; ?></div>

          <div class="field-title">Date Of Birth</div>
          <input type="date" class="dob-tag" id="dob-input" name="dob" />
          <div class="field-err" id="dob-err">*<?php echo $dob_err; ?></div>

          <div class="field-title">Gender</div>
          <div>
            <input type="radio" class="gender-tag" value="Male" name="gender" checked />Male<br>
            <input type="radio" class="gender-tag" value="Female" name="gender" />Female<br>
          </div>
          <div class="field-err" id="gender-err">*<?php echo $gender_err; ?></div>

        </div>

      </div>

      <div class="err-container" id="err-tag"><?php echo $err; ?></div>

      <input type="submit" class="login-button" id="login-button" value="Register" name="register">

      <div class="register-text">Already have an account ? <a href="login.php">Log in</a></div>

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