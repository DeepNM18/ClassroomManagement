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
    
  )";
  
  $conn->close();

?>