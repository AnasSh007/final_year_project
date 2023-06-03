<?php
require('config.php');
$id = $_REQUEST["id"];
$sql = "SELECT * FROM USERS WHERE id = '$id'";
$result = $conn->query($sql);
$row = $result->fetch_array();
$id = $row['id'];
$name = $row['name'];
$email = $row['email'];
$password = $row['password'];
$role = $row['role'];
$gender = $row['gender'];
$status = $row['status'];
$additional_info = $row['additional_info'];
$object = array();
$object[] = array(
  "id" => $id,
  "name" => $name,
  "email" => $email,
  "password" => $password,
  "role" => $role,
  "gender" => $gender,
  "status" => $status,
  "additional_info" => $additional_info
);
echo json_encode($object);
?>