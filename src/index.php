<?php
session_start();
if (!$_SESSION['username']) {
  header('Location: login.php');
}
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
        <span class="text-4xl text-gray-600">3</span>
        <span class="text-xl text-gray-600 space-x-2">
          <i class="fa-solid fa-user-tie"></i><span>Admins</span>
        </span>
      </div>
      <div
        class="w-60 h-36 rounded-md drop-shadow shadow-black bg-gray-50 p-6 flex flex-col justify-start space-y-5 cursor-pointer hover:bg-gray-200 transition-all ease-in-out duration-300">
        <span class="text-4xl text-gray-600">48</span>
        <span class="text-xl text-gray-600 space-x-2">
          <i class="fa-solid fa-users"></i><span>Employees</span>
        </span>
      </div>
      <div
        class="w-60 h-36 rounded-md drop-shadow shadow-black bg-gray-50 p-6 flex flex-col justify-start space-y-5 cursor-pointer hover:bg-gray-200 transition-all ease-in-out duration-300">
        <span class="text-4xl text-gray-600">178</span>
        <span class="text-xl text-gray-600 space-x-2">
          <i class="fa-solid fa-layer-group"></i> <span>Total Assets</span>
        </span>
      </div>
      <div
        class="w-60 h-36 rounded-md drop-shadow shadow-black bg-gray-50 p-6 flex flex-col justify-start space-y-5 cursor-pointer hover:bg-gray-200 transition-all ease-in-out duration-300">
        <span class="text-4xl text-gray-600">112</span>
        <span class="text-xl text-gray-600 space-x-2">
          <i class="fa-solid fa-layer-group"></i> <span>Assigned Assets</span>
        </span>
      </div>
    </div>
  </section>
</body>

</html>