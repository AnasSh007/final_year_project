<?php
require('config.php');
session_start();
if (!$_SESSION['username']) {
  header('Location: login.php');
}
$sql = "SELECT * FROM ASSETS";
$result = $conn->query($sql);
$sqlForRepairing = "SELECT * FROM ASSETS WHERE STATUS = 'Repairing'";
$RepairingAssets = $conn->query($sqlForRepairing);
if (isset($_GET['submit'])) {
  $id = $_GET['id'];
  $product = $_GET['product'];
  $vendor = $_GET['vendor'];
  $description = $_GET['description'];
  $purchase_price = $_GET['purchase_price'];
  $barcode = $_GET['barcode'];
  $status = $_GET['status'];
  $categoryId = $_GET['categoryId'];
  $sql = "UPDATE ASSETS SET PRODUCT = '$product', VENDOR = '$vendor', DESCRIPTION ='$description', purchase_price = '$purchase_price', barcode='$barcode', status = '$status', categoryId = '$categoryId' WHERE id='$id' ";
  $result = $conn->query($sql);
  header('Location: assets.php');
  if (!$result == TRUE) {
    echo "Error:" . $sql . "<br>" . $conn->error;
  }
  $conn->close();
}
if (isset($_GET['saveEditedRepairingAssetBtn'])) {

}
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
        <h1 class="text-3xl text-gray-600">Assets</h1>
        <button class="bg-gray-500 hover:bg-gray-600 px-1 text-white rounded">
          <a href="newAsset.php">
            <i class="fa-solid fa-plus"></i>
          </a>
        </button>
      </div>
      <canvas id="barcodeCanvas" class="cursor-pointer h-[70px] w-[150px]" style="box-shadow: inset 0px 0px 5px grey;"
        onclick="printBarcode()"></canvas>
    </span>
    <table class="text-gray-600 text-center w-full mt-5 text-sm">
      <thead class="border-b text-gray-50 uppercase bg-gray-500 h-8">
        <tr>
          <th>Sr#</th>
          <th>Asset Name</th>
          <th>Vendor</th>
          <th>Description</th>
          <th>Purchase Price</th>
          <th>Status</th>
          <th>Category</th>
          <th>Actions</th>
          <th>Barcode</th>
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
              <?php echo $value['product'] ?>
            </td>
            <td>
              <?php echo $value['vendor'] ?>
            </td>
            <td>
              <?php echo $value['description'] ?>
            </td>
            <td>
              <?php echo $value['purchase_price'] ?>
            </td>
            <td>
              <?php echo $value['status'] ?>
            </td>
            <td>
              <?php
              $category_sql = "SELECT CATEGORY FROM CATEGORIES WHERE ID = '{$value["categoryId"]}'";
              $category = $conn->query($category_sql);
              $res = $category->fetch_array();
              echo $res['CATEGORY']; ?>
            </td>
            <td class="space-x-1">
              <button class="cursor-pointer hover:text-gray-900" id="editUserModalBtn"
                onclick="getAsset(<?php echo $value['id'] ?>)">
                <i class="fa-solid fa-pen"></i>
              </button>
              <span>|</span>
              <button onclick="deleteAsset(<?php echo $value['id'] ?>)" class="cursor-pointer hover:text-gray-900">
                <i class="fa-regular fa-trash-can"></i>
              </button>
            </td>
            <td>
              <span class="cursor-pointer" onclick=generateBarcode(<?php echo $value['barcode'] ?>)>
                <i class="fa-solid fa-barcode"></i>
              </span>
            </td>
          </tr>
          <?php
          $counter = $counter + 1;
        } ?>
      </tbody>
    </table>
    <h2 class="my-4 text-xl text-gray-600">Repairing Assets List</h2>
    <table class="text-gray-600 text-center w-full mt-5 text-sm">
      <thead class="border-b text-gray-50 uppercase bg-gray-500 h-8">
        <tr>
          <th>Sr#</th>
          <th>Asset Name</th>
          <th>Vendor</th>
          <th>Description</th>
          <th>Status</th>
          <th>Category</th>
          <th>Info</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $counter = 1;
        foreach ($RepairingAssets as $key => $value) {
          ?>
          <tr class="border-b border-gray-400 h-10 hover:border-b-2">
            <td>
              <?php echo $counter ?>
            </td>
            <td>
              <?php echo $value['product'] ?>
            </td>
            <td>
              <?php echo $value['vendor'] ?>
            </td>
            <td>
              <?php echo $value['description'] ?>
            </td>
            <td>
              <?php echo $value['status'] ?>
            </td>
            <td>
              <?php
              $category_sql = "SELECT CATEGORY FROM CATEGORIES WHERE ID = '{$value["categoryId"]}'";
              $category = $conn->query($category_sql);
              $res = $category->fetch_array();
              echo $res['CATEGORY']; ?>
            </td>
            <td>
              <button class="cursor-pointer hover:text-gray-900" id="editUserModalBtn"
                onclick="getRepairingAsset(<?php echo $value['id'] ?>)">
                <i class="fa-solid fa-circle-info"></i>
              </button>
            </td>
          </tr>
          <?php
          $counter = $counter + 1;
        } ?>
      </tbody>
    </table>
  </section>

  <!-- Edit Asset Modal Container -->
  <div id="editAssetModal" class="hidden fixed left-0 top-0 flex justify-center items-center h-screen w-full"
    style="background-color: rgba(0, 0, 0, 0.5)">
    <!-- Edit Asset Modal -->
    <div class="w-1/3 bg-gray-50 drop-shadow-sm shadow-gray-600 p-5 rounded-md">
      <div class="flex justify-center items-center">
        <form method="GET">
          <div class="flex flex-col space-y-1">
            <h1 class="text-gray-600 text-lg mb-1 text-center">
              Edit Asset
            </h1>
            <input type="hidden" name="id" id="editId">
            <label for="product">
              <span class="text-gray-600"> Product: </span></label>
            <input type="text" name="product" id="editProduct" placeholder="Laptop"
              class="text-gray-600 focus:outline-none" />
            <label for="vendor">
              <span class="text-gray-600"> Vendor: </span></label>
            <input type="text" name="vendor" id="editVendor" placeholder="Toshiba"
              class="text-gray-600 focus:outline-none" />
            <label for="description">
              <span class="text-gray-600"> Description: </span></label>
            <input type="text" name="description" id="editDescription" placeholder="enter description here..."
              class="text-gray-600 focus:outline-none" />
            <label for="purchase_price">
              <span class="text-gray-600"> Purchase Price: </span></label>
            <input type="text" name="purchase_price" id="editPurchase_price" placeholder="50000"
              class="text-gray-600 focus:outline-none" />
            <label for="barcode">
              <span class="text-gray-600"> Barcode: </span></label>
            <input type="text" name="barcode" id="editBarcode" placeholder="xxxxxxxxxxxxxxx"
              class="text-gray-600 focus:outline-none" />
            <select id="editCategoryId" name="categoryId" class="p-1 focus:outline-none text-gray-700 cursor-pointer">
              <option value="" value="none" selected disabled hidden>
                Category
              </option>
              <option value="1">Cat 1</option>
              <option value="2">Cat 2</option>
            </select>
            <select id="editStatus" name="status" class="p-1 focus:outline-none text-gray-700 cursor-pointer">
              <option value="" value="none" selected disabled hidden>
                Status
              </option>
              <option value="Using">Using</option>
              <option value="Not Using">Not Using</option>
              <option value="Repairing">Repairing</option>
            </select>
            <div class="flex justify-evenly">
              <button id="saveEditedAssetBtn" type="submit" name="submit"
                class="rounded items-center text-white bg-gray-600 hover:bg-gray-700 p-1 drop-shadow-sm w-fit px-3 shadow-black">
                <i class="fa-solid fa-check"></i> Save
              </button>
              <button id="closeEditUserModalBtn"
                class="rounded items-center text-white bg-gray-600 hover:bg-gray-700 p-1 drop-shadow-sm w-fit px-3 shadow-black">
                <i class="fa-solid fa-xmark"></i> <a href="assets.php">Close</a>
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Edit Repairing Asset Modal Container -->
  <div id="editRepairingAssetModal" class="hidden fixed left-0 top-0 flex justify-center items-center h-screen w-full"
    style="background-color: rgba(0, 0, 0, 0.5)">
    <!-- Edit Repairing Asset Modal -->
    <div class="w-1/3 bg-gray-50 drop-shadow-sm shadow-gray-600 p-5 rounded-md">
      <div class="flex justify-center items-center">
        <form method="GET" onsubmit="return validateRepairingForm()">
          <div class="flex flex-col space-y-1">
            <h1 class="text-gray-600 text-lg mb-1 text-center">
              Repairing Asset
            </h1>
            <input type="hidden" name="id" id="editRepairingId">
            <label for="product">
              <span class="text-gray-600"> Product: </span></label>
            <input type="text" disabled name="product" id="editRepairingProduct"
              class="text-gray-600 focus:outline-none cursor-not-allowed" />
            <span class="text-gray-600"> Repairing Cost: </span></label>
            <input type="text" name="repairingCost" id="repairingCost" class="text-gray-600 focus:outline-none"
              placeholder="10000" />
            <select id="editRepairingStatus" name="status" class="p-1 focus:outline-none text-gray-700 cursor-pointer">
              <option value="" value="none" selected disabled hidden>
                Status
              </option>
              <option value="Using">Using</option>
              <option value="Not Using">Not Using</option>
              <option value="Repairing">Repairing</option>
            </select>
            <div class="flex justify-evenly">
              <button id="saveEditedRepairingAssetBtn" type="submit" name="saveEditedRepairingAssetBtn"
                class="rounded items-center text-white bg-gray-600 hover:bg-gray-700 p-1 drop-shadow-sm w-fit px-3 shadow-black">
                <i class="fa-solid fa-check"></i> Save
              </button>
              <button id="closeEditUserModalBtn"
                class="rounded items-center text-white bg-gray-600 hover:bg-gray-700 p-1 drop-shadow-sm w-fit px-3 shadow-black">
                <i class="fa-solid fa-xmark"></i> <a href="assets.php">Close</a>
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>


  <script>
    // var barcodeIsActive = false;
    function getAsset(id) {
      const editModal = document.getElementById("editAssetModal");
      editModal.classList.remove("hidden");
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          let result = JSON.parse(this.responseText)[0];
          console.log(result);
          document.getElementById('editId').value = result.id;
          document.getElementById('editProduct').value = result.product;
          document.getElementById('editVendor').value = result.vendor;
          document.getElementById('editDescription').value = result.description;
          document.getElementById('editPurchase_price').value = result.purchase_price;
          document.getElementById('editBarcode').value = result.barcode;
          document.getElementById('editStatus').value = result.status;
          document.getElementById('editCategoryId').value = result.categoryId;
        };
      }
      xmlhttp.open("GET", "getAsset.php?id=" + id, true);
      xmlhttp.send();
    }

    function getRepairingAsset(id) {
      const editModal = document.getElementById("editRepairingAssetModal");
      editModal.classList.remove("hidden");
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          let result = JSON.parse(this.responseText)[0];
          console.log(result);
          document.getElementById('editRepairingId').value = result.id;
          document.getElementById('editRepairingProduct').value = result.product;
          document.getElementById('editRepairingStatus').value = result.status;
        };
      }
      xmlhttp.open("GET", "getAsset.php?id=" + id, true);
      xmlhttp.send();
    }

    function validateRepairingForm() {
      let repairingStatus = document.getElementById('editRepairingStatus').value;
      let repairingCost = document.getElementById('repairingCost').value;
      if (repairingStatus.value == 'Repairing') {
        alert('Please Change Status');
        return false;
      }
      if (repairingCost.value.trim() === '') {
        alert('Please Enter a Repairing Cost');
        return false;
      }
    }

    function deleteAsset(id) {
      let ok = confirm("Do You Want To Delete This Record ?");
      if (!ok) return;
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          console.log(this.responseText);
          location.reload();

        }
      };
      xmlhttp.open("GET", "deleteAsset.php?id=" + id, true);
      xmlhttp.send();
    }
    //generate barcode function
    function generateBarcode(barcodeInput) {
      console.log(barcodeInput);
      barcodeIsActive = true;
      JsBarcode("#barcodeCanvas", barcodeInput);
    }
    function printBarcode() {
      printElementById('barcodeCanvas');
    }
    function printElementById(elementId) {
      const element = document.getElementById(elementId);

      if (element) {
        const printWindow = window.open('', '', 'width=600,height=600');
        printWindow.document.write('<html><head><title>Print</title></head><body>');
        printWindow.document.write(element.outerHTML);
        printWindow.document.write('</body></html>');
        printWindow.document.close();

        const images = printWindow.document.getElementsByTagName('img');
        let imagesLoaded = 0;
        for (let i = 0; i < images.length; i++) {
          images[i].onload = function () {
            imagesLoaded++;
            if (imagesLoaded === images.length) {
              printWindow.onload = function () {
                printWindow.focus();
                printWindow.print();
                // printWindow.close();
              };
              printWindow.onload();
            }
          };
        }
      } else {
        console.log('Element with ID ' + elementId + ' not found.');
      }
    }

  </script>
</body>

</html>