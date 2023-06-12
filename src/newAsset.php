<?php
require('config.php');
require('head.php');
session_start();
if (!$_SESSION['username']) {
  header("Location: login.php");
}
if (isset($_POST['submit'])) {
  $productName = $_POST['productName'];
  $vendor = $_POST['vendor'];
  $price = $_POST['price'];
  $description = $_POST['description'];
  $category = $_POST['category'];
  $status = $_POST['status'];
  $barcode = rand(0, 100000000000000);
  // $barcode = "PIECYFER-" . $random;
  $sql = "INSERT INTO ASSETS(PRODUCT, VENDOR, DESCRIPTION, PURCHASE_PRICE, BARCODE, STATUS, CATEGORYID) VALUES('$productName', '$vendor','$description','$price', '$barcode', '$status','$category')";
  $result = $conn->query($sql);
  if ($result == TRUE) {

    echo "New record created successfully.";

  } else {

    echo "Error:" . $sql . "<br>" . $conn->error;

  }
  $conn->close();
  header('Location: assets.php');
}
?>
<div id="newUserModal" class="fixed left-0 top-0 flex justify-center items-center h-screen w-full"
  style="background-color: rgba(0, 0, 0, 0.5)">
  <div class="w-1/3 bg-gray-50 drop-shadow-sm shadow-gray-600 p-5 rounded-md">
    <div class="flex justify-center items-center">
      <form action="" method="POST">
        <div class="flex flex-col space-y-1">
          <h1 class="text-gray-600 text-lg mb-1 text-center">
            Add New Asset
          </h1>
          <label for="username">
            <span class="text-gray-600"> Product Name: </span></label>
          <input type="text" placeholder="Laptop" name="productName" class="text-gray-600 focus:outline-none" />
          <label for="">
            <span class="text-gray-600"> Vendor: </span></label>
          <input type="text" name="vendor" class="text-gray-600 focus:outline-none" placeholder="Microsoft" />
          <label for="password">
            <span class="text-gray-600"> Description: </span></label>
          <input type="text" name="description" placeholder="enter description here..."
            class="text-gray-600 focus:outline-none" />
          <span class="text-gray-600"> Purchase Price: </span></label>
          <input type="number" name="price" placeholder="enter description here..."
            class="text-gray-600 focus:outline-none" />
          <select name="category" class="p-1 focus:outline-none text-gray-700 cursor-pointer">
            <option value="" value="none" selected disabled hidden>
              Category
            </option>
            <option value="1">Cat 1</option>
            <option value="2">Cat 2</option>
          </select>
          <select name="status" class="p-1 focus:outline-none text-gray-700 cursor-pointer">
            <option value="" value="none" selected disabled hidden>
              Status
            </option>
            <option value="Using">Using</option>
            <option value="Not Using">Not Using</option>
            <option value="Repairing">Repairing</option>
          </select>
          <br />
          <div class="flex justify-evenly">
            <button id="saveNewUserBtn" type="submit" name="submit"
              class="rounded items-center text-white bg-gray-600 hover:bg-gray-700 p-1 drop-shadow-sm w-fit px-3 shadow-black">
              <i class="fa-solid fa-check"></i> Save
            </button>
            <button id="closeNewUserModalBtn"
              class="rounded items-center text-white bg-gray-600 hover:bg-gray-700 p-1 drop-shadow-sm w-fit px-3 shadow-black">
              <i class="fa-solid fa-xmark"></i><a href="assets.php"> Close </a>
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>