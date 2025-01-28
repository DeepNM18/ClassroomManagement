<?php

  include("connection.php");

  session_start();

  if(!isset($_SESSION['uid'][$_GET['sk']]))
  {
    header("Location:login.php");
    exit();
  }

  $sk = $_GET['sk'];
  $uid = $_SESSION['uid'][$sk];

  $err = "";
  $classcode = "";

  $count1 = 0;

  if(isset($_POST['join']))
  {
    $classcode = $_POST['classcode'];

    if(empty($classcode))
    {
      $err = "Classroom code is reqiured.";
    }
    else
    {
      if(!preg_match("/^[a-zA-Z0-9]+$/",$classcode))
      {
        $err = "Invalid input: Only letters, numbers are allowed.";
      }
      else
      {
        $err = "";
      }
    }

    if($err === "")
    {
      $conn = mysqli_connect("localhost:3306","root","",$dbname);

      $sql = "SELECT * FROM ClassroomCodes WHERE JoiningCode = '{$classcode}'";
      $result = mysqli_query($conn,$sql) or die("Unable to Search classroom code");
      while($data = mysqli_fetch_array($result))
      {
        $codeid = $data['CodeId'];
        $role = $data['Role'];
        $count1 = 1;

        if($role === "Teacher")
        {
          $sql = "SELECT * FROM ClassroomMst WHERE TeacherJoiningCodeId = {$codeid}";
        }
        else if($role === "Student")
        {
          $sql = "SELECT * FROM ClassroomMst WHERE StudentJoiningCodeId = {$codeid}";
        }
        else
        {
          die("Unable to join classroom");
        }

        $result2 = mysqli_query($conn,$sql) or die("Unable to retireve classroom id");
        while($data2 = mysqli_fetch_array($result2))
        {
          $classroomid = $data2['ClassroomId'];

          $sql = "INSERT INTO ClassroomUser (UserId,ClassroomId,Role,JoiningDate) VALUES ({$uid},{$classroomid},'{$role}',SYSDATE())";
          if(mysqli_query($conn,$sql))
          {
            $_SESSION['classroom'][$sk] = $classroomid;
            header("Location:classroom.php?sk=".$sk);
            exit();
          }
          else
          {
            die("Unable to join classroom");
          }
        }
      }
      if($count1 === 0)
      {
        $err = "Couldn't join the class. Check the code and the account, then try again.";
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
  <link rel="stylesheet" href="../Styles/joinClassroom.css?v=<?php echo time(); ?>" />
</head>

<body>
  <div class="primary-container">
    <form class="main-container" id="form1" action="joinClassroom.php?sk=<?php echo $sk; ?>" method="post">
      <div class="title-text">Join class</div>
      <div class="body-text">Enter class code to join a classroom</div>
      <input type="text" name="classcode" class="input-tag"
        placeholder="Ask your teacher for the class code, then enter it here.">
      <div class="field-err" id="err">*<?php echo $err; ?></div>
      <input type="submit" name="join" class="join-button" id="join-button">
    </form>
  </div>

  <script>
  let btn = document.getElementById('login-button');
  btn.addEventListener('click', function() {
    window.location.href = "login.php";
  });
  </script>

</body>

</html>