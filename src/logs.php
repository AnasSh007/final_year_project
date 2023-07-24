<?php
require('config.php');
session_start();
if (!$_SESSION['username']) {
  header('Location: login.php');
}
$sql = "SELECT * FROM LOGS ORDER BY ID DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<?php require('head.php') ?>

<body class="bg-gray-100" id="body">
  <!-- Header -->
  <?php require('header.php') ?>

  <!-- Aside Bar -->
  <?php require('aside.php') ?>


  <!-- Dashboard -->
  <section class="container p-6 ml-[20%] inline-block h-fit w-4/5 bottom-0 overflow-y-scroll">
    <span class="flex justify-between items-center">
      <div class="flex justify-between items-center space-x-4 mx-1 mb-3">
        <h1 class="text-3xl text-blue-800">Logs</h1>
      </div>
    </span>
    <table class="text-gray-600 text-center w-full mt-5 text-sm">
      <thead class="border-b text-gray-50 uppercase bg-blue-600 h-8">
        <tr>
          <th>Sr#</th>
          <th>Log</th>
          <th>Repairing Cost</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $counter = 1;
        foreach ($result as $key => $value) {
          ?>
          <tr class="border-b border-gray-400 h-10 hover:text-blue-800">
            <td>
              <?php echo $counter ?>
            </td>
            <td>
              <?php echo $value['description'] ?>
            </td>
            <td>
              <b>
                <?php echo $value['repairing_cost'] ?>
              </b>
            </td>
            <td>
              <?php echo $value['date'] ?>
            </td>
          </tr>
          <?php
          $counter = $counter + 1;
        } ?>
      </tbody>
      <script>
        async () => {
          let logs = await <?php echo json_encode($result); ?>;
          console.log("Hiiiiii");
          console.log(logs);
        }
        let log = {};
        // function func() {
        // console.log(logs);
        // }
      </script>
    </table>
  </section>
</body>

</html>