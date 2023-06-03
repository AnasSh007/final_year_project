<?php
require('config.php');
session_start();
if (!$_SESSION['username']) {
  header('Location: login.php');
}
$sql = "SELECT * FROM USERS";
$result = $conn->query($sql);
if (isset($_GET['submit'])) {
  $id = $_GET['id'];
  $name = $_GET['username'];
  $email = $_GET['email'];
  $password = $_GET['password'];
  $role = $_GET['role'];
  $gender = $_GET['gender'];
  $status = $_GET['status'];
  $additional_info = $_GET['additional_info'];
  $sql = "UPDATE USERS SET NAME = '$name', PASSWORD = '$password', EMAIL='$email', STATUS = '$status', GENDER='$gender', ROLE = '$role', ADDITIONAL_INFO = '$additional_info' WHERE id='$id' ";
  $result = $conn->query($sql);
  header('Location: employees.php');
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
        <h1 class="text-3xl text-gray-600">Employees</h1>
        <button id="newUserModalBtn" class="bg-gray-500 hover:bg-gray-600 px-1 text-white rounded">
          <a href="newUser.php">
            <i class="fa-solid fa-plus"></i>
          </a>
        </button>
      </div>
      <!-- <div>
        <input class="bg-gray-100 text-lg text-gray-600 focus:outline-none outline-none border-b-2" type="text"
          id="myInput" onkeyup="myFunction()" placeholder="Search Employees Here" />
      </div> -->
    </span>
    <table class="text-gray-600 text-center w-full mt-5 text-sm">
      <thead class="border-b text-gray-50 uppercase bg-gray-500 h-8">
        <tr>
          <th>Sr#</th>
          <th>Name</th>
          <th>Role</th>
          <th>Assigned Assets</th>
          <th>Actions</th>
          <th>Assets</th>
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
              <?php echo $value['name'] ?>
            </td>
            <td>
              <?php echo $value['role'] ?>
            </td>
            <td>3</td>
            <td class="space-x-1">
              <button class="cursor-pointer hover:text-gray-900" id="editUserModalBtn"
                onclick="getUser(<?php echo $value['id'] ?>)">
                <i class="fa-regular fa-pen-to-square"></i>
              </button>
              <span>|</span>
              <button onclick="deleteUser(<?php echo $value['id'] ?>)" class="cursor-pointer hover:text-gray-900">
                <i class="fa-solid fa-user-xmark"></i>
              </button>
            </td>
            <td class="cursor-pointer">
              <button class="">
                <i class="fa-solid fa-layer-group"></i>
              </button>
            </td>
          </tr>
          <?php
          $counter = $counter + 1;
        } ?>
      </tbody>
    </table>
  </section>


  <!-- Edit User Modal Container -->
  <div id="editUserModal" class="hidden fixed left-0 top-0 flex justify-center items-center h-screen w-full"
    style="background-color: rgba(0, 0, 0, 0.5)">
    <!-- Edit User Modal -->
    <div class="w-1/3 bg-gray-50 drop-shadow-sm shadow-gray-600 p-5 rounded-md">
      <div class="flex justify-center items-center">
        <form method="GET">
          <div class="flex flex-col space-y-1">
            <h1 class="text-gray-600 text-lg mb-1 text-center">
              Edit Employee
            </h1>
            <input type="hidden" name="id" id="editId">
            <label for="username">
              <span class="text-gray-600"> Name: </span></label>
            <input type="text" name="username" id="editName" placeholder="Muhammad Anas"
              class="text-gray-600 focus:outline-none" />
            <label for="username">
              <span class="text-gray-600"> Email: </span></label>
            <input type="email" name="email" id="editEmail" placeholder="example@gmail.com"
              class="text-gray-600 focus:outline-none" />
            <label for="password">
              <span class="text-gray-600"> Password: </span></label>
            <input type="text" name="password" id="editPassword" placeholder="enter password here..."
              class="text-gray-600 focus:outline-none" />
            <select id="editRole" name="role" class="p-1 focus:outline-none text-gray-700 cursor-pointer">
              <option value="" value="none" selected disabled hidden>
                Role
              </option>
              <option value="admin">Admin</option>
              <option value="employee">Employee</option>
            </select>
            <select id="editGender" name="gender" class="p-1 focus:outline-none text-gray-700 cursor-pointer">
              <option value="" value="none" selected disabled hidden>
                Gender
              </option>
              <option value="male">Male</option>
              <option value="female">Female</option>
            </select>
            <select id="editStatus" name="status" class="p-1 focus:outline-none text-gray-700 cursor-pointer">
              <option value="" value="none" selected disabled hidden>
                Status
              </option>
              <option value="active">Active</option>
              <option value="not active">Not Active</option>
            </select>
            <!-- <label for="image">
              <span class="text-gray-600"> Avatar: </span></label>
            <input type="file" class="text-sm text-gray-600 focus:outline-none" /> -->
            <textarea id="editAdditional" name="additional_info" id="" cols="30" rows="3"
              class="p-2 focus:outline-none text-gray-700" placeholder="additional info..."></textarea>
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
    function getUser(id) {
      const editModal = document.getElementById("editUserModal");
      editModal.classList.remove("hidden");
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          let result = JSON.parse(this.responseText)[0];
          console.log(result);
          document.getElementById('editId').value = result.id;
          document.getElementById('editName').value = result.name;
          document.getElementById('editPassword').value = result.password;
          document.getElementById('editEmail').value = result.email;
          document.getElementById('editStatus').value = result.status;
          document.getElementById('editRole').value = result.role;
          document.getElementById('editGender').value = result.gender;
          document.getElementById('editAdditional').value = result.additional_info;
        }
      };
      xmlhttp.open("GET", "getUser.php?id=" + id, true);
      xmlhttp.send();
    }

    function deleteUser(id) {
      let ok = confirm("Do You Want To Delete This Record ?");
      if (!ok) return;
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          console.log(this.responseText);
        }
      };
      xmlhttp.open("GET", "deleteUser.php?id=" + id, true);
      xmlhttp.send();
      location.reload();
    }
  </script>
</body>

</html>