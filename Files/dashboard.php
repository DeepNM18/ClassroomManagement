<?php
  include("connection.php");
  session_start();
  // echo $_SESSION['uid'];
  if(!isset($_SESSION['uid']))
  {
    header("Location:login.php");
    exit();
  }

  $uid = $_SESSION['uid'];
  $classroomName = "";
  
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>

  <link rel="stylesheet" href="../Styles/dashboard.css?v=<?php echo time(); ?>" />
  <link rel="stylesheet" href="../Styles/joinedClassrooms.css?v=<?php echo time(); ?>" />

</head>

<body>
  <div class="sidebar-container">
    <div class="dashboard-title">
      <div>Student-Teacher</div>
      <div>Management System</div>
    </div>

    <div class="sidebar-home">
      <button class="home-button">
        <img src="../resources/images/icons8-home-30.png">
        <div>Home</div>
      </button>
    </div>

    <div class="sidebar-classroom">

      <div class="classroom-section">
        <img class="classroom-icon" src="../resources/images/icons8-google-classroom-50.png">
        <div>Classrooms</div>
      </div>

      <div class="mini-classrooms">

        <div class="mini-classroom-container">
          <img src="../resources/Banners/banner5.jpg" class="mini-classroom-banner" />
          <div class="mini-classroom-details" id="c101">
            <div class="mini-classroom-title">B.Sc. IT Sem 6</div>
            <div class="mini-classroom-desc">This classroom is of batch 2024-25 of department of ICT</div>
          </div>
          <script>
          var cid101 = document.getElementById('c101');
          cid101.addEventListener('click', function() {
            window.location.href = "classroom.php?cid=101";
          });
          </script>
        </div>

        <div class="mini-classroom-container">
          <img src="../resources/Banners/banner6.jpg" class="mini-classroom-banner" />
          <div class="mini-classroom-details" id="c102">
            <div class="mini-classroom-title">B.Sc. IT Sem 6</div>
            <div class="mini-classroom-desc">This classroom is of batch 2024-25 of department of ICT</div>
          </div>
          <script>
          var cid102 = document.getElementById('c102');
          cid102.addEventListener('click', function() {
            window.location.href = "classroom.php?cid=102";
          });
          </script>
        </div>

      </div>

    </div>

    <button class="logout-button" id="logout-button">
      <img src="../resources/images/logout_white.png">
      <div>Logout</div>
    </button>

    <script>
    var logoutButton = document.getElementById('logout-button');
    logoutButton.addEventListener('click', function() {
      window.location.href = "logout.php";
    });
    </script>

  </div>


  <div class="header-container">
    <div class="classroom-name-container">
      <?php
        echo $classroomName;
      ?>
    </div>

    <button class="create-classroom">
      <img class="plus-image" src="../resources/images/plus_white_v2.png" />
      <div class="plus-text">Create a<br>Classroom</div>
    </button>

    <button class="join-classroom">
      <img class="join-image" src="../resources/images/login.png" />
      <div class="join-text">Join a<br>Classroom</div>
    </button>

    <button class="profilepic-container">
      <?php
        $conn = mysqli_connect("localhost:3306","root","",$dbname);
        if(!$conn)
        {
          die("Unable to connect to database");
        }
        $sql = "SELECT * FROM User WHERE UserId = {$uid}";
        $result = mysqli_query($conn,$sql);

        while($data = mysqli_fetch_array($result))
        {
          if($data['ProfilePicURL'] != "")
          {
            echo "<img class=\"profilepic\" src=\"{$data['ProfilePicURL']}\" />";
          }
          else
          {
            echo "<img class=\"profilepic\" src=\"../resources/profilepics/default-profile-pic.png\" />";
          }
        }
      ?>
    </button>
  </div>