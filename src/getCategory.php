<?php
require('config.php');
$id = $_REQUEST["id"];
$sql = "SELECT * FROM CATEGORIES WHERE id = '$id'";
$result = $conn->query($sql);
$row = $result->fetch_array();
$id = $row['id'];
$category = $row['category'];
$object = array();
$object[] = array(
  "id" => $id,
  "category" => $category,
);
echo json_encode($object);
?>