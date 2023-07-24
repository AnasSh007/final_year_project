<header class="bg-gray-50 h-2/6 w-screen float-right drop-shadow shadow-black inline-block">
  <section class="flex justify-end">
    <div class="flex w-4/5 justify-evenly items-center">
      <!-- User Image and User Name -->
      <div class="flex items-center justify-start px-4 w-1/2 space-x-5 h-20">
        <img src="../img/user.webp" class="w-12 rounded-full" alt="user-image" />
        <span class="text-blue-800">
          <?php echo $_SESSION['username'] ?>
        </span>
      </div>
      <!-- LogOut Button -->
      <div class="flex items-center justify-end px-4 w-1/2 space-x-5 h-20">
        <form action="" method="POST">
          <button type="submit" name="submit"
            class="rounded text-white bg-blue-600 hover:bg-blue-800 p-1.5 drop-shadow-sm shadow-black space-x-1">
            <i class="fa-solid fa-arrow-right-from-bracket"></i>
            <span>Log Out</span>
          </button>
        </form>
      </div>
    </div>
  </section>
</header>

<?php
if (isset($_POST['submit'])) {
  session_destroy();
  header("Location: login.php");
}
?>