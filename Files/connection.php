<?php
  $conn = mysqli_connect("localhost:3306","root","");

  if(!$conn)
  {
    die("Unable to connect to database");
  }

  $dbname = "classroom";

  $sql = "CREATE DATABASE IF NOT EXISTS $dbname";

  if(!mysqli_query($conn,$sql))
  {
    die("Unable to create database");
  }

  $conn->close();

  $conn = mysqli_connect("localhost:3306","root","",$dbname);

  if(!$conn)
  {
    die("Unable to connect to database");
  }

  $sql = "CREATE TABLE IF NOT EXISTS User (
    UserId INT AUTO_INCREMENT PRIMARY KEY,
    FullName VARCHAR(50),
    Email VARCHAR(150) UNIQUE,
    Password VARCHAR(150),
    ProfilePicURL VARCHAR(200),
    DOB DATE,
    Gender VARCHAR(10),
    CreateDate DATE
  )";

  if(!mysqli_query($conn,$sql))
  {
    die("Unable to create User table");
  }

  $sql = "CREATE TABLE IF NOT EXISTS ClassroomCodes(
    CodeId INT AUTO_INCREMENT PRIMARY KEY,
    JoiningCode VARCHAR(10) UNIQUE,
    Role VARCHAR(100)
  )";

  if(!mysqli_query($conn,$sql))
  {
    die("Unable to create ClassroomCodes table");
  }

  $sql = "CREATE TABLE IF NOT EXISTS ClassroomMst(
    ClassroomId INT AUTO_INCREMENT PRIMARY KEY,
    ClassroomName VARCHAR(150),
    ClassroomDesc VARCHAR(250),
    CreatedDate DATE,
    UserId INT,
    StudentJoiningCodeId INT,
    TeacherJoiningCodeId INT,
    BannerURL VARCHAR(250),
    FOREIGN KEY (UserId) REFERENCES User(UserId) ON DELETE SET NULL,
    FOREIGN KEY (StudentJoiningCodeId) REFERENCES ClassroomCodes(CodeId) ON DELETE SET NULL,
    FOREIGN KEY (TeacherJoiningCodeId) REFERENCES ClassroomCodes(CodeId) ON DELETE SET NULL
  )";

  if(!mysqli_query($conn,$sql))
  {
    die("Unable to create Classroom table");
  }

  $sql = "CREATE TABLE IF NOT EXISTS ClassroomUser(
    CUId INT AUTO_INCREMENT PRIMARY KEY,
    UserId INT,
    ClassroomId INT,
    Role VARCHAR(100),
    JoiningDate DATE,
    FOREIGN KEY (UserId) REFERENCES User(UserId) ON DELETE SET NULL,
    FOREIGN KEY (ClassroomId) REFERENCES ClassroomMst(ClassroomId) ON DELETE SET NULL
  )";

  if(!mysqli_query($conn,$sql))
  {
    die("Unable to create ClassroomUser table");
  }
  
  $conn->close();

?>