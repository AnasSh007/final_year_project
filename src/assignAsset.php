<?php
require('config.php');
session_start();
if (!$_SESSION['username']) {
  header('Location: login.php');
}
// $sql = "SELECT * FROM USERS";
// $result = $conn->query($sql);
if (isset($_GET['submit'])) {
  $id = $_GET['assignuserid'];
  $name = $_GET['assignAsset'];
  echo "<script>alert('$name', '$id')</script>";
  // $sql = "UPDATE USERS SET NAME = '$name', PASSWORD = '$password', EMAIL='$email', STATUS = '$status', GENDER='$gender', ROLE = '$role', ADDITIONAL_INFO = '$additional_info' WHERE id='$id' ";
  // $result = $conn->query($sql);
  // header('Location: employees.php');
  // if (!$result == TRUE) {
  //   echo "Error:" . $sql . "<br>" . $conn->error;
  // }
  // $conn->close();
}

echo "<script>alert('assignAswasdf page');</script>";

?>