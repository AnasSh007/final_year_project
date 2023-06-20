<?php
require('config.php');
session_start();
if (!$_SESSION['username']) {
  header('Location: login.php');
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
        <h1 class="text-3xl text-gray-600">Search Market</h1>
      </div>
      <div>
        <Button onclick="refreshData()"
          class="rounded-sm text-white bg-gray-500 hover:bg-gray-600 p-1.5 px-2.5 drop-shadow-sm shadow-black space-x-1"><i
            class="fa-solid fa-arrow-rotate-right"></i></Button>
        <Button onclick="fetchLaptopCSV()"
          class="mx-5 rounded-sm text-white bg-gray-500 hover:bg-gray-600 p-1.5 drop-shadow-sm shadow-black space-x-1">Laptops</Button>
        <Button onclick="fetchMobileCSV()"
          class="rounded-sm text-white bg-gray-500 hover:bg-gray-600 p-1.5 drop-shadow-sm shadow-black space-x-1">Mobiles</Button>
      </div>
    </span>
    <div id="toastContainer"></div>
    <table id="myTable" class="text-gray-600 text-center w-full mt-5 text-sm">
      <thead class="border-b text-gray-50 uppercase bg-gray-500 h-8">
        <tr>
          <th>Sr#</th>
          <th>Product</th>
          <th>Price</th>
          <th>Reviews</th>
          <th>Link</th>
          <th>Location</th>
        </tr>
      </thead>
      <tbody id="output"></tbody>
    </table>

  </section>


  <script src="https://cdn.jsdelivr.net/npm/papaparse@5.3.0"></script>

  <script>
    var fetched;

    // ../laptops.csv
    async function fetchMobileCSV() {
      fetched = "Mobile";
      try {
        let response = await fetch('../mobiles.csv');
        console.log(response);
        let csvData = await response.text();
        console.log(csvData);
        let parsedData = Papa.parse(csvData);
        displayData(parsedData);
      } catch (error) {
        console.error('Error fetching CSV:', error);
      }
    }

    // ../laptops.csv
    async function fetchLaptopCSV() {
      fetched = "Laptop";
      document.getElementById('output').innerHTML = "";
      try {
        let response = await fetch('../laptops.csv');
        let csvData = await response.text();
        console.log(csvData);
        let parsedData = Papa.parse(csvData);
        console.log(parsedData);
        displayData(parsedData);
      } catch (error) {
        console.error('Error fetching CSV:', error);
      }
    }

    function parseCSV(csvData) {
      let rows = csvData.split('\n');
      let headers = rows[0].split(',');

      let data = [];
      for (let i = 1; i < rows.length; i++) {
        let values = rows[i].split(',');
        if (values.length === headers.length) {
          let entry = {};
          for (let j = 0; j < headers.length; j++) {
            entry[headers[j]] = values[j];
          }
          data.push(entry);

        }
      }

      return data;
    }

    function displayData(obj) {

      let table = document.getElementById('output');
      table.innerHTML = "";
      obj.data.forEach((array, index) => {
        if (index == 0)
          return;
        let row = table.insertRow();
        row.classList.add("cursor-pointer", "border-b", "border-gray-400", "h-10", "hover:border-b-2");

        let serialNoCell = row.insertCell();
        serialNoCell.classList.add("font-bold");
        serialNoCell.textContent = index;

        let nameCell = row.insertCell();
        nameCell.textContent = array[0];

        let priceCell = row.insertCell();
        priceCell.textContent = array[2];

        let reviewsCell = row.insertCell();
        reviewsCell.textContent = array[3];

        let linkCell = row.insertCell();
        let linkAnchor = document.createElement('a');
        linkAnchor.href = array[1];
        linkAnchor.innerHTML = '<i class="fa-solid fa-arrow-up-right-from-square"></i>';
        linkCell.appendChild(linkAnchor);

        let locationCell = row.insertCell();
        locationCell.textContent = array[4];
      });
    }

    // ------------------------------------------------------------

    function refreshData() {
      if (fetched == 'Laptop') {
        fetch('http://127.0.0.1:5050/scraped-data')
          .then(response => {
            if (!response.ok) {
              throw new Error('Network response was not OK');
            }
            else {
              showToast('Data Refreshed, Press Laptops Button');
            }
          })
          .catch(error => {
            console.error(error);
          });
      }
      else if (fetched == 'Mobile') {
        fetch('http://127.0.0.1:5050/scraped-data-mobiles')
          .then(response => {
            if (!response.ok) {
              throw new Error('Network response was not OK');
            }
            else {
              showToast('Data Refreshed, Press Mobiles Button');
            }
          })
          .catch(error => {
            console.error(error);
          });
      }

    }

    // ------------------------------------------------------------

    function showToast(msg) {
      let toastContainer = document.getElementById("toastContainer");

      // Create toast element
      let toast = document.createElement("div");
      toast.classList.add("toast");
      toast.innerText = msg;

      // Add toast element to container
      toastContainer.appendChild(toast);

      // Show toast
      toastContainer.classList.add("show");

      // Hide toast after 3 seconds
      setTimeout(() => {
        toastContainer.classList.remove("show");
        // Remove toast element from container
        toastContainer.removeChild(toast);
      }, 3000);
    }

  </script>
</body>

</html>