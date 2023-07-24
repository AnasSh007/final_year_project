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

$no_categories = "SELECT * FROM categories";
$result5 = $conn->query($no_categories);
$rows5 = mysqli_fetch_all($result5, MYSQLI_ASSOC); // Fetch all rows as an associative array
$associativeArray = array_map('json_decode', array_map('json_encode', $rows5));
// Initialize an array to store the counts for each category.
$categoryCounts = array();

// Loop through each category in $rows5.
foreach ($rows5 as $category) {
  $categoryId = $category['id'];

  // Execute a SQL query to count assets in the assets table for the current category.
  $countQuery = "SELECT COUNT(*) AS assetCount FROM assets WHERE categoryId = $categoryId";
  $resultCount = $conn->query($countQuery);
  $rowCount = mysqli_fetch_assoc($resultCount);

  // Store the count in the categoryCounts array using the category ID as the key.
  $categoryCounts[$categoryId] = $rowCount['assetCount'];
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
    <h1 class="text-3xl text-blue-800 mx-1 mb-3">Dashboard</h1>
    <section class="flex justify-center mb-10 w-full">
      <canvas id="myChart" style="width:100%;max-width:490px"></canvas>
      <canvas id="myChart2" style="width:100%;max-width:490px"></canvas>
    </section>
    <div class="flex flex-wrap justify-start items-center gap-6">
      <!-- card -->
      <div
        class="w-60 h-36 rounded-md drop-shadow shadow-black bg-gray-50 p-6 flex flex-col justify-start space-y-5 cursor-pointer hover:bg-gray-200 transition-all ease-in-out duration-300">
        <span class="text-4xl text-gray-600">
          <?php echo $userCount ?>
        </span>
        <span class="text-xl text-blue-800 space-x-2">
          <i class="fa-solid fa-users"></i><span>Employees</span>
        </span>
      </div>
      <div
        class="w-60 h-36 rounded-md drop-shadow shadow-black bg-gray-50 p-6 flex flex-col justify-start space-y-5 cursor-pointer hover:bg-gray-200 transition-all ease-in-out duration-300">
        <span class="text-4xl text-gray-600">
          <?php echo $adminCount ?>
        </span>
        <span class="text-xl text-blue-800 space-x-2">
          <i class="fa-solid fa-user-tie"> </i>
          <span>Admins</span>
        </span>
      </div>
      <div
        class="w-60 h-36 rounded-md drop-shadow shadow-black bg-gray-50 p-6 flex flex-col justify-start space-y-5 cursor-pointer hover:bg-gray-200 transition-all ease-in-out duration-300">
        <span class="text-4xl text-gray-600">
          <?php echo $assetsCount ?>
        </span>
        <span class="text-xl text-blue-800 space-x-2">
          <i class="fa-solid fa-layer-group"></i> <span>Total Assets</span>
        </span>
      </div>
      <div
        class="w-60 h-36 rounded-md drop-shadow shadow-black bg-gray-50 p-6 flex flex-col justify-start space-y-5 cursor-pointer hover:bg-gray-200 transition-all ease-in-out duration-300">
        <span class="text-4xl text-gray-600">
          <?php echo $catCount ?>
        </span>
        <span class="text-xl text-blue-800 space-x-2">
          <i class="fa-solid fa-layer-group"></i> <span>Total Categories</span>
        </span>
      </div>
      <div
        class="w-60 h-36 rounded-md drop-shadow shadow-black bg-gray-50 p-6 flex flex-col justify-start space-y-5 cursor-pointer hover:bg-gray-200 transition-all ease-in-out duration-300">
        <span class="text-4xl text-gray-600">
          <?php echo $logCount ?>
        </span>
        <span class="text-xl text-blue-800 space-x-2">
          <i class="fa-regular fa-calendar"></i> <span>Logs</span>
        </span>
      </div>
    </div>
  </section>
  <script>
    var rowData = <?php echo json_encode($associativeArray); ?>;
    var categoryCounts = <?php echo json_encode($categoryCounts); ?>;
    var categoryCountArray = Object.values(categoryCounts);
    console.log("Category Count Array = ", categoryCountArray);
    console.log("Row = ", rowData);
    var xValues = [];
    var yValues = [];
    rowData.forEach(element => {
      xValues.push(element.category);
    });
    categoryCountArray.forEach(element => {
      yValues.push(element);
    });
    var barColors = [
      "#b91d47",
      "#00aba9",
      "#2b5797",
      "#e8c3b9",
      "#1e7145",
      "#f09a36",
      "#7d3eb5",
      "#4fc328",
      "#d43ccf",
      "#92c4c8",
      "#5c3aae",
      "#ef3f26",
      "#39a952",
      "#db8cd3",
      "#4cb4cc"
    ];


    new Chart("myChart", {
      type: "pie",
      data: {
        labels: xValues,
        datasets: [{
          backgroundColor: barColors,
          data: yValues
        }]
      },
      options: {
        title: {
          display: true,
          text: "Asset Categories"
        }
      }
    });

    var barColors = barColors.reverse();
    new Chart("myChart2", {
      type: "bar",
      data: {
        labels: xValues,
        datasets: [{
          backgroundColor: barColors,
          data: yValues
        }]
      },
      options: {
        legend: { display: false },
        title: {
          display: true,
          // text: "Asset Categories"
        }
      }
    });
  </script>
</body>

</html>