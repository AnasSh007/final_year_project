<?php
require('config.php');
$id = $_REQUEST["id"];
$sql = "DELETE FROM LOGS WHERE assetId = '$id'";
$result = $conn->query($sql);
$sql = "DELETE FROM ASSETS WHERE id = '$id'";
$result = $conn->query($sql);
if (!$result == TRUE) {
  echo "Error:" . $sql . "<br>" . $conn->error;
}
echo $result;
?>