<?php
require('config.php');
require('head.php');
session_start();
if (!$_SESSION['username']) {
  header("Location: login.php");
}
if (isset($_POST['submit'])) {
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $role = $_POST['role'];
  $gender = $_POST['gender'];
  $status = $_POST['status'];
  $additional_info = $_POST['additional_info'];
  $sql = "INSERT INTO USERS(NAME, EMAIL, PASSWORD, ROLE, GENDER, STATUS, ADDITIONAL_INFO) VALUES('$username', '$email','$password','$role','$gender','$status', '$additional_info')";
  $result = $conn->query($sql);
  if ($result == TRUE) {

    echo "New record created successfully.";

  } else {

    echo "Error:" . $sql . "<br>" . $conn->error;

  }
  $conn->close();
  header('Location: employees.php');
}
?>
<div id="newUserModal" class="fixed left-0 top-0 flex justify-center items-center h-screen w-full"
  style="background-color: rgba(0, 0, 0, 0.5)">
  <div class="w-1/3 bg-gray-50 drop-shadow-sm shadow-gray-600 p-5 rounded-md">
    <div class="flex justify-center items-center">
      <form action="" method="POST">
        <div class="flex flex-col space-y-1">
          <h1 class="text-gray-600 text-lg mb-1 text-center">
            Add New Employee
          </h1>
          <label for="username">
            <span class="text-gray-600"> Name: </span></label>
          <input type="text" placeholder="Muhammad Anas" name="username" class="text-gray-600 focus:outline-none" />
          <label for="username">
            <span class="text-gray-600"> Email: </span></label>
          <input type="email" placeholder="example@gmail.com" name="email" class="text-gray-600 focus:outline-none" />
          <label for="password">
            <span class="text-gray-600"> Password: </span></label>
          <input type="password" name="password" placeholder="enter password here..."
            class="text-gray-600 focus:outline-none" />
          <select name="role" class="p-1 focus:outline-none text-gray-700 cursor-pointer">
            <option value="" value="none" selected disabled hidden>
              Role
            </option>
            <option value="admin">Admin</option>
            <option value="employee">Employee</option>
          </select>

          <select name="gender" class="p-1 focus:outline-none text-gray-700 cursor-pointer">
            <option value="" value="none" selected disabled hidden>
              Gender
            </option>
            <option value="male">Male</option>
            <option value="female">Female</option>
          </select>
          <select name="status" class="p-1 focus:outline-none text-gray-700 cursor-pointer">
            <option value="" value="none" selected disabled hidden>
              Status
            </option>
            <option value="active">Active</option>
            <option value="not active">Not Active</option>
          </select>
          <!-- <label for="image">
            <span class="text-gray-600"> Avatar: </span></label
          >
          <input
            type="file"
            class="text-sm text-gray-600 focus:outline-none"
          /> -->
          <textarea name="additional_info" id="" cols="30" rows="3" class="p-2 focus:outline-none text-gray-700"
            placeholder="additional info..."></textarea>
          <div class="flex justify-evenly">
            <button id="saveNewUserBtn" type="submit" name="submit"
              class="rounded items-center text-white bg-gray-600 hover:bg-gray-700 p-1 drop-shadow-sm w-fit px-3 shadow-black">
              <i class="fa-solid fa-check"></i> Save
            </button>
            <button id="closeNewUserModalBtn"
              class="rounded items-center text-white bg-gray-600 hover:bg-gray-700 p-1 drop-shadow-sm w-fit px-3 shadow-black">
              <i class="fa-solid fa-xmark"></i><a href="employees.php"> Close </a>
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>