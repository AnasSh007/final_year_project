<?php
require('config.php');
require('head.php');
session_start();
if (!$_SESSION['username']) {
  header("Location: login.php");
}
if (isset($_POST['submit'])) {
  $category = $_POST['category'];
  $sql = "INSERT INTO CATEGORIES(CATEGORY) VALUES('$category')";
  $result = $conn->query($sql);
  if ($result == TRUE) {
    echo "New record created successfully.";
  } else {
    echo "Error:" . $sql . "<br>" . $conn->error;
  }
  $conn->close();
  header('Location: categories.php');
}
?>
<div id="newUserModal" class="fixed left-0 top-0 flex justify-center items-center h-screen w-full"
  style="background-color: rgba(0, 0, 0, 0.5)">
  <div class="w-1/3 bg-gray-50 drop-shadow-sm shadow-gray-600 p-5 rounded-md">
    <div class="flex justify-center items-center">
      <form action="" method="POST">
        <div class="flex flex-col space-y-1">
          <h1 class="text-blue-800 text-lg mb-1 text-center">
            Add New Category
          </h1>
          <label for="category">
            <span class="text-blue-800"> Category: </span></label>
          <input type="text" placeholder="Enter category name here..." name="category"
            class="text-gray-600 focus:outline-none" />
          <br />
          <div class="flex justify-evenly">
            <button type="submit" name="submit"
              class="rounded items-center text-white bg-blue-600 hover:bg-blue-800 p-1 drop-shadow-sm w-fit px-3 shadow-black">
              <i class="fa-solid fa-check"></i> Save
            </button>
            <button
              class="rounded items-center text-white bg-blue-600 hover:bg-blue-800 p-1 drop-shadow-sm w-fit px-3 shadow-black">
              <i class="fa-solid fa-xmark"></i><a href="categories.php"> Close </a>
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>