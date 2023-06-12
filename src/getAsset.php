<?php
require('config.php');
$id = $_REQUEST["id"];
$sql = "SELECT * FROM ASSETS WHERE id = '$id'";
$result = $conn->query($sql);
$row = $result->fetch_array();
$id = $row['id'];
$product = $row['product'];
$vendor = $row['vendor'];
$description = $row['description'];
$purchase_price = $row['purchase_price'];
$barcode = $row['barcode'];
$status = $row['status'];
$categoryId = $row['categoryId'];
$object = array();
$object[] = array(
  "id" => $id,
  "product" => $product,
  "vendor" => $vendor,
  "description" => $description,
  "purchase_price" => $purchase_price,
  "barcode" => $barcode,
  "status" => $status,
  "categoryId" => $categoryId
);
echo json_encode($object);
?>