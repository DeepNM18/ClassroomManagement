<?php
  include("connection.php");
  session_start();

  $name = $desc = $banner = "";
  $name_err = $desc_err = $err = "";
  $bannerno = 1;

  // echo $_SESSION['uid'];
  if(!isset($_SESSION['uid'][$_GET['sk']]))
  {
    header("Location:login.php");
    exit();
  }

  $sk = $_GET['sk'];
  $uid = $_SESSION['uid'][$sk];

  if(isset($_POST['create']))
  {
    $name = $_POST['name'];
    $desc = $_POST['desc'];
    $banner = $_POST['banner'];

    if(empty($name))
    {
      $name_err = "Classroom name field cannot be empty";
    }
    else
    {
      $name_err = "";
      // if(!preg_match("/^[a-zA-Z0-9\s_-]*$/",$name))
      // {
      //   $name_err = "Invalid input: Only letters, numbers, spaces are allowed.";
      // }
      // else
      // {
      //   $name_err = "";
      // }
    }

    if(empty($desc))
    {
      $desc_err = "Classroom description field cannot be empty";
    }
    else
    {
      $desc_err = "";
      // if(!preg_match("/^[a-zA-Z0-9\s_-]*$/",$desc))
      // {
      //   $desc_err = "Invalid input: Only letters, numbers, spaces, underscores, and hyphens are allowed.";
      // }
      // else
      // {
      //   $desc_err = "";
      // }
    }

    if($name_err === "" && $desc_err === "")
    {
      $studCode = substr(uniqid(),-8);
      $teacherCode = substr(uniqid(),-8);

      $conn = mysqli_connect("localhost:3306","root","",$dbname);
      if(!$conn)
      {
        die("Unable to connect to database");
      }

      $sql = "INSERT INTO ClassroomCodes (JoiningCode,Role) VALUES ('{$studCode}','Student')";
      if(mysqli_query($conn,$sql))
      {
        $studcodeid = $conn->insert_id;
        $sql = "INSERT INTO ClassroomCodes (JoiningCode,Role) VALUES ('{$teacherCode}','Teacher')";
        if(mysqli_query($conn,$sql))
        {
          $teachercodeid = $conn->insert_id;
          $sql = "INSERT INTO ClassroomMst(ClassroomName,ClassroomDesc,CreatedDate,UserId,StudentJoiningCodeId,TeacherJoiningCodeId,BannerURL) VALUES ('{$name}','{$desc}',SYSDATE(),{$uid},{$studcodeid},{$teachercodeid},'{../resources/Banners/$banner}')";
          if(mysqli_query($conn,$sql))
          {
            $cid = $conn->insert_id;
            $sql = "INSERT INTO ClassroomUser (UserId,ClassroomId,Role,JoiningDate) VALUES ({$uid},{$cid},'Teacher',SYSDATE())";
            if(mysqli_query($conn,$sql))
            {
              $_SESSION['classroom'][$sk] = $cid;
              header("Location:classroom.php?sk=".$sk);
              exit();
            }
          }
        }
      }
    }

  }

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../Styles/createClassroom.css?v=<?php echo time(); ?>" />
</head>

<body>
  <div class="primary-container">
    <form class="form-container" id="form1" action="createClassroom.php?sk=<?php echo $sk; ?>" method="post">

      <div class="form-title">Create Your Classroom</div>

      <div class="field-title">Classroom Name</div>
      <input type="text" class="name-tag" id="name-input" name="name" />
      <div class="field-err" id="name-err">*<?php echo $name_err; ?></div>

      <div class="field-title">Classroom Description</div>
      <input type="text" class="desc-tag" id="desc-input" name="desc" />
      <div class="field-err" id="desc-err">*<?php echo $desc_err; ?></div>

      <div class="field-title">Select a Banner</div>
      <div class="banner-container">
        <div class="left-banner-container">
          <img class="classroom-banner" src="../resources/Banners/banner1.jpg" alt="Banner 1" data-value="banner1.jpg"
            onclick="selectBanner(this)" id="firstbanner">
          <img class="classroom-banner" src="../resources/Banners/banner2.jpg" alt="Banner 2" data-value="banner2.jpg"
            onclick="selectBanner(this)">
          <img class="classroom-banner" src="../resources/Banners/banner3.jpg" alt="Banner 3" data-value="banner3.jpg"
            onclick="selectBanner(this)">
        </div>
        <div class="right-banner-container">
          <img class="classroom-banner" src="../resources/Banners/banner4.jpg" alt="Banner 4" data-value="banner4.jpg"
            onclick="selectBanner(this)">
          <img class="classroom-banner" src="../resources/Banners/banner5.jpg" alt="Banner 5" data-value="banner5.jpg"
            onclick="selectBanner(this)">
          <img class="classroom-banner" src="../resources/Banners/banner6.jpg" alt="Banner 6" data-value="banner6.jpg"
            onclick="selectBanner(this)">
        </div>
      </div>
      <input type="text" id="banner-input" name="banner" hidden />

      <input type="submit" class="create-button" id="create-button" name="create" value="Create">

    </form>
  </div>

  <script>
  function selectBanner(element) {
    const banners = document.querySelectorAll('.classroom-banner');
    banners.forEach(banner => banner.classList.remove('selected'));
    element.classList.add('selected');
    document.getElementById('banner-input').value = element.dataset.value;
    console.log(element.dataset.value);
  }

  var firstBanner = document.getElementById('firstbanner');
  selectBanner(firstBanner);
  </script>

</body>

</html>