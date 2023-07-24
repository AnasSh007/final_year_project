<?php
include "config.php";
if (isset($_POST['submit'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $sql = "SELECT * FROM USERS WHERE NAME = '$username' AND PASSWORD = '$password'";
  $result = $conn->query($sql);
  $object = $result->fetch_array();
  if (!$object) {
    echo "<script>alert('user not found, check password or username')</script>";
  } else if ($object && $object['role'] == 'admin' && $object['status'] == 'active') {
    // creating session
    session_start();
    $_SESSION["username"] = $object['name'];
    header("Location: index.php");
  } else {
    $name = $object['name'];
    echo "<script>alert('Access denied to $name')</script>";
  }
  $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<?php require 'head.php'; ?>

<body class="bg-gray-200">
  <!-- Login Card -->
  <div class="flex justify-center items-center h-screen">
    <section class="flex justify-center items-center bg-gray-50 w-2/5 h-96 drop-shadow shadow-black rounded-lg">
      <div class="flex flex-col items-center justify-evenly mx-auto p-2 pt-8 cursor-pointer">
        <img src="../img/logo-removebg-preview.png" class="w-14 mb-5" alt="PieCyfer-logo" />
        <span class="flex flex-col justify-center text-lg text-center text-blue-800">PieCyfer Asset Deck</span>
      </div>
      <form action="" method="POST">
        <div class="flex flex-col space-y-1">
          <h1 class="text-blue-800 text-xl mb-5">Login</h1>
          <label for="username">
            <span class="text-blue-800 text-lg"> Username: </span></label>
          <input type="text" placeholder="example@gmail.com" class="text-lg text-gray-600 focus:outline-none"
            name="username" />
          <label for="password">
            <span class="text-blue-800 text-lg"> Password: </span></label>
          <input type="password" placeholder="enter password here..." class="text-lg text-gray-600 focus:outline-none"
            name="password" />
          <button type="submit" name="submit" value="submit"
            class="rounded items-center text-white bg-blue-600 hover:bg-blue-800 p-1.5 drop-shadow-sm w-fit px-5 shadow-black">
            Log In
          </button>
          <!-- <a href="forgot-password.html" class="text-gray-600 hover:underline">Forgot your password?</a> -->
        </div>
      </form>
    </section>
  </div>
</body>

</html>