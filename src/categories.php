<?php
require('config.php');
session_start();
if (!$_SESSION['username']) {
  header('Location: login.php');
}
$sql = "SELECT * FROM CATEGORIES";
$result = $conn->query($sql);
if (isset($_GET['submit'])) {
  $id = $_GET['id'];
  $category = $_GET['category'];
  $sql = "UPDATE CATEGORIES SET CATEGORY = '$category' WHERE id='$id' ";
  $result = $conn->query($sql);
  header('Location: categories.php');
  if (!$result == TRUE) {
    echo "Error:" . $sql . "<br>" . $conn->error;
  }
  $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<?php require('head.php') ?>

<body class="bg-gray-100">
  <!-- Header -->
  <?php require('header.php') ?>

  <!-- Aside Bar -->
  <?php require('aside.php') ?>

  <!-- Dashboard -->
  <section class="container p-6 ml-[20%] inline-block h-fit w-4/5 bottom-0 overflow-y-scroll">
    <span class="flex justify-between items-center">
      <div class="flex justify-between items-center space-x-4 mx-1 mb-3">
        <h1 class="text-3xl text-gray-600">Asset Categories</h1>
        <button class="bg-gray-500 hover:bg-gray-600 px-1 text-white rounded">
          <a href="newCategory.php">
            <i class="fa-solid fa-plus"></i>
          </a>
        </button>
      </div>
    </span>
    <table class="text-gray-600 text-center w-full mt-5 text-sm">
      <thead class="border-b text-gray-50 uppercase bg-gray-500 h-8">
        <tr>
          <th>Sr#</th>
          <th>Category Name</th>
          <th>Assets</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $counter = 1;
        foreach ($result as $key => $value) {
          ?>
          <tr class="border-b border-gray-400 h-10 hover:border-b-2">
            <td>
              <?php echo $counter ?>
            </td>
            <td>
              <?php echo $value['category'] ?>
            </td>
            <td>
              10
            </td>
            <td class="space-x-1">
              <button class="cursor-pointer hover:text-gray-900" id="editUserModalBtn"
                onclick="getCategory(<?php echo $value['id'] ?>)">
                <i class="fa-solid fa-pen"></i>
              </button>
              <span>|</span>
              <button onclick="deleteCategory(<?php echo $value['id'] ?>)" class="cursor-pointer hover:text-gray-900">
                <i class="fa-regular fa-trash-can"></i>
              </button>
            </td>
          </tr>
          <?php
          $counter = $counter + 1;
        } ?>
      </tbody>
    </table>
  </section>

  <!-- Edit Category Modal Container -->
  <div id="editCategoryModal" class="hidden fixed left-0 top-0 flex justify-center items-center h-screen w-full"
    style="background-color: rgba(0, 0, 0, 0.5)">
    <!-- Edit User Modal -->
    <div class="w-1/3 bg-gray-50 drop-shadow-sm shadow-gray-600 p-5 rounded-md">
      <div class="flex justify-center items-center">
        <form method="GET">
          <div class="flex flex-col space-y-1">
            <h1 class="text-gray-600 text-lg mb-1 text-center">
              Edit Category
            </h1>
            <span class="text-gray-600"> Category Name: </span></label>
            <input type="text" name="category" id="editCategory" placeholder="Furniture..."
              class="text-gray-600 focus:outline-none" />
            <input type="hidden" name="id" id="editId">
            <div class="flex justify-evenly">
              <button id="saveEditedUserBtn" type="submit" name="submit"
                class="rounded items-center text-white bg-gray-600 hover:bg-gray-700 p-1 drop-shadow-sm w-fit px-3 shadow-black">
                <i class="fa-solid fa-check"></i> Save
              </button>
              <button id="closeEditUserModalBtn"
                class="rounded items-center text-white bg-gray-600 hover:bg-gray-700 p-1 drop-shadow-sm w-fit px-3 shadow-black">
                <i class="fa-solid fa-xmark"></i> <a href="employees.php">Close</a>
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script>
    function getCategory(id) {
      const editModal = document.getElementById("editCategoryModal");
      editModal.classList.remove("hidden");
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          let result = JSON.parse(this.responseText)[0];
          console.log(result);
          document.getElementById('editId').value = result.id;
          document.getElementById('editCategory').value = result.category;
        }
      };
      xmlhttp.open("GET", "getCategory.php?id=" + id, true);
      xmlhttp.send();
    }

    function deleteCategory(id) {
      let ok = confirm("Do You Want To Delete This Record ?");
      if (!ok) return;
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          console.log(this.responseText);
        }
      };
      xmlhttp.open("GET", "deleteCategory.php?id=" + id, true);
      xmlhttp.send();
      location.reload();
    }
  </script>
</body>

</html>