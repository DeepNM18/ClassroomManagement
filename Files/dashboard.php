<?php
  include("connection.php");
  session_start();
  // echo $_SESSION['uid'];
  
  // if(!isset($_SESSION['uid'][$_GET['sk']]))
  // {
  //   header("Location:login.php");
  //   exit();
  // }
  // $uid = $_SESSION['uid'][$_GET['sk']];

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
      <button class="home-button" onclick="homeRedirect()">
        <img src="../resources/images/icons8-home-30.png">
        <div>Home</div>
      </button>
    </div>

    <script>
    function homeRedirect() {
      window.location.href = "joinedClassrooms.php?sk=" + <?php echo $sk ?>;
    }
    </script>

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
      window.location.href = "logout.php?sk=" + <?php echo $sk; ?>;
    });
    </script>

  </div>


  <div class="header-container">
    <div class="classroom-name-container">
      <?php
        echo $classroomName;
      ?>
    </div>

    <button class="create-classroom" onclick="createClassroom()">
      <img class="plus-image" src="../resources/images/plus_white_v2.png" />
      <div class="plus-text">Create a<br>Classroom</div>
    </button>

    <button class="join-classroom" onclick="joinClassroom()">
      <img class="join-image" src="../resources/images/login.png" />
      <div class="join-text">Join a<br>Classroom</div>
    </button>

    <script>
    function createClassroom() {
      window.location.href = "createClassroom.php?sk=" + <?php echo $sk; ?>;
    }

    function joinClassroom() {
      window.location.href = "joinClassroom.php?sk=" + <?php echo $sk; ?>;
    }
    </script>

    <button class="profilepic-container" id="profile-btn">
      <?php
        $conn = mysqli_connect("localhost:3306", "root", "", $dbname);
        if (!$conn) {
            die("Unable to connect to database");
        }
        $sql = "SELECT * FROM User WHERE UserId = {$uid}";
        $result = mysqli_query($conn, $sql);
        $data = mysqli_fetch_array($result);

        $profilePic = $data['ProfilePicURL'] ?: "../resources/profilepics/default-profile-pic.png";
        echo "<img class=\"profilepic\" src=\"$profilePic\" />";
    ?>
    </button>

    <div class="user-info-container">
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
          $pfname = $data['FullName'];
          $pemail = $data['Email'];
          $pdob = $data['DOB'];
          $pimage = $data['ProfilePicURL'];
          $pgender = $data['Gender'];
          $pcdate = $data['CreateDate'];
          echo "
            <div class=\"user-info\" id=\"userInfo\">
              <img src=\"$pimage\" alt=\"User Avatar\" class=\"user-avatar\">
              <h3>$pfname</h3>
              <p><i class=\"fas fa-envelope\"></i> $pemail</p>
              <p><i class=\"fas fa-calendar-alt\"></i> Date Of Birth : $pdob</p>
              <p><i class=\"fas fa-envelope\"></i> Gender : $pgender</p>
              <p><i class=\"fas fa-calendar-alt\"></i> Signup Date : $pcdate</p>
              <a href=\"editProfile.php?sk=$sk\" class=\"edit-profile-btn\">Edit Profile</a>
            </div>

            <script>
              const profilePic = document.getElementById(\"profile-btn\");
              const userInfo = document.getElementById(\"userInfo\");

              // Toggle user info with animation
              profilePic.addEventListener(\"click\", (event) => {
                  event.stopPropagation();
                  userInfo.classList.toggle(\"show\");
              });

              // Hide when clicking outside
              document.addEventListener(\"click\", (event) => {
                  if (!userInfo.contains(event.target) && event.target !== profilePic) {
                      userInfo.classList.remove(\"show\");
                  }
              });
            </script>
          ";
        }
      ?>
    </div>
  </div>