<?php
require('config.php');
session_start();
if (!$_SESSION['username']) {
  header('Location: login.php');
}

$users = "SELECT COUNT(*) AS user_count FROM users";
$result = $conn->query($users);
$row = $result->fetch_assoc();
$userCount = $row['user_count'];
// echo "<script>alert('$userCount')</script>";

$admins = "SELECT COUNT(*) AS admin_count FROM users WHERE role = 'admin'";
$result2 = $conn->query($admins);
$row2 = $result2->fetch_assoc();
$adminCount = $row2['admin_count'];
// echo "<script>alert('$adminCount')</script>";

$assets = "SELECT COUNT(*) AS assets_count FROM assets";
$result3 = $conn->query($assets);
$row3 = $result3->fetch_assoc();
$assetsCount = $row3['assets_count'];
// echo "<script>alert('$assetsCount')</script>";

$cat = "SELECT COUNT(*) AS cat_count FROM categories";
$result3 = $conn->query($cat);
$row3 = $result3->fetch_assoc();
$catCount = $row3['cat_count'];
// echo "<script>alert('$adminCount')</script>";

$logs = "SELECT COUNT(*) AS log_count FROM logs";
$result4 = $conn->query($logs);
$row4 = $result4->fetch_assoc();
$logCount = $row4['log_count'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <link href="/dist/output.css" rel="stylesheet" />
</head>
<?php
require 'head.php';
?>

<body class="bg-gray-100">
  <!-- Header -->
  <?php require('header.php') ?>

  <!-- Aside Bar -->
  <?php require('aside.php'); ?>

  <!-- Dashboard -->
  <section class="container p-6 ml-[20%] inline-block h-fit w-4/5 bottom-0 overflow-y-scroll">
    <h1 class="text-3xl text-gray-600 mx-1 mb-3">Dashboard</h1>
    <div class="flex flex-wrap justify-start items-center gap-6">
      <!-- card -->
      <div
        class="w-60 h-36 rounded-md drop-shadow shadow-black bg-gray-50 p-6 flex flex-col justify-start space-y-5 cursor-pointer hover:bg-gray-200 transition-all ease-in-out duration-300">
        <span class="text-4xl text-gray-600">
          <?php echo $userCount ?>
        </span>
        <span class="text-xl text-gray-600 space-x-2">
          <i class="fa-solid fa-user-tie"></i><span>Admins</span>
        </span>
      </div>
      <div
        class="w-60 h-36 rounded-md drop-shadow shadow-black bg-gray-50 p-6 flex flex-col justify-start space-y-5 cursor-pointer hover:bg-gray-200 transition-all ease-in-out duration-300">
        <span class="text-4xl text-gray-600">
          <?php echo $adminCount ?>
        </span>
        <span class="text-xl text-gray-600 space-x-2">
          <i class="fa-solid fa-users"></i><span>Employees</span>
        </span>
      </div>
      <div
        class="w-60 h-36 rounded-md drop-shadow shadow-black bg-gray-50 p-6 flex flex-col justify-start space-y-5 cursor-pointer hover:bg-gray-200 transition-all ease-in-out duration-300">
        <span class="text-4xl text-gray-600">
          <?php echo $assetsCount ?>
        </span>
        <span class="text-xl text-gray-600 space-x-2">
          <i class="fa-solid fa-layer-group"></i> <span>Total Assets</span>
        </span>
      </div>
      <div
        class="w-60 h-36 rounded-md drop-shadow shadow-black bg-gray-50 p-6 flex flex-col justify-start space-y-5 cursor-pointer hover:bg-gray-200 transition-all ease-in-out duration-300">
        <span class="text-4xl text-gray-600">
          <?php echo $catCount ?>
        </span>
        <span class="text-xl text-gray-600 space-x-2">
          <i class="fa-solid fa-layer-group"></i> <span>Total Categories</span>
        </span>
      </div>
      <div
        class="w-60 h-36 rounded-md drop-shadow shadow-black bg-gray-50 p-6 flex flex-col justify-start space-y-5 cursor-pointer hover:bg-gray-200 transition-all ease-in-out duration-300">
        <span class="text-4xl text-gray-600">
          <?php echo $logCount ?>
        </span>
        <span class="text-xl text-gray-600 space-x-2">
          <i class="fa-regular fa-calendar"></i> <span>Logs</span>
        </span>
      </div>
    </div>
  </section>
</body>

</html>