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
        <button onclick="refreshData()"
          class="rounded-sm text-white bg-gray-500 hover:bg-gray-600 p-1.5 px-2.5 drop-shadow-sm shadow-black space-x-1"><i
            class="fa-solid fa-arrow-rotate-right"></i></button>
        <!-- <label for="filterBy" class="mr-2">Filters:</label>
        <select id="filterBy"
          class="rounded-sm text-white bg-gray-500 hover:bg-gray-600 p-1.5 px-2.5 drop-shadow-sm shadow-black space-x-1"
          onselect="applyFilters()">
          <option value="select">Select</option>
          <option value="name">Name</option>
          <option value="price">Price</option>
          <option value="reviews">Reviews</option>
        </select> -->
        <button onclick="fetchLaptopCSV('../laptops.csv')"
          class="mx-5 rounded-sm text-white bg-gray-500 hover:bg-gray-600 p-1.5 drop-shadow-sm shadow-black space-x-1">Laptops</button>
        <button onclick="fetchMobileCSV('../mobiles.csv')"
          class="rounded-sm text-white bg-gray-500 hover:bg-gray-600 p-1.5 drop-shadow-sm shadow-black space-x-1">Mobiles</button>
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
  <script src="https://kit.fontawesome.com/your-font-awesome-kit.js"></script>

  <script>
    var fetched;
    var data = []; // Variable to store the original data
    let fetched_dataset_laptop = false;
    let fetched_dataset_mobile = false;
    let laptops_data = [];
    // let laptop = {};

    // ../laptops.csv
    async function fetchMobileCSV(file_path) {
      fetched = "Mobile";
      try {
        let response = await fetch(file_path);
        let csvData = await response.text();
        let parsedData = Papa.parse(csvData);
        displayData(parsedData);
      } catch (error) {
        console.error('Error fetching CSV:', error);
      }
      for (let i = 0; i < 1; i++) {
        if (fetched_dataset_mobile) {
          break;
        }
        fetchMobileCSV('../mobiles-dataset.csv');
        console.log('printed');
        fetched_dataset_mobile = true;
      }
    }

    // ../laptops.csv
    async function fetchLaptopCSV(file_path) {
      fetched = "Laptop";
      document.getElementById('output').innerHTML = "";
      try {
        let response = await fetch(file_path); // file_path = '../laptops.csv'
        let csvData = await response.text();
        let parsedData = Papa.parse(csvData);
        displayData(parsedData);
      } catch (error) {
        console.error('Error fetching CSV:', error);
      }
      for (let i = 0; i < 1; i++) {
        if (fetched_dataset_laptop) {
          break;
        }
        fetchLaptopCSV('../laptops-dataset.csv');
        console.log('printed');
        fetched_dataset_laptop = true;
      }
    }


    function displayData(obj) {
      data = obj.data; // Store the parsed data

      let table = document.getElementById('output');
      table.innerHTML = "";
      data.forEach((array, index) => {

        let laptop = {};

        if (index === 0) return; // Skip header row
        let row = table.insertRow();
        row.classList.add("cursor-pointer", "border-b", "border-gray-400", "h-10", "hover:border-b-2");

        let serialNoCell = row.insertCell();
        serialNoCell.classList.add("font-bold");
        serialNoCell.textContent = index;

        let nameCell = row.insertCell();
        nameCell.textContent = array[0];
        laptop.name = array[0];

        let priceCell = row.insertCell();
        priceCell.textContent = array[2];
        laptop.price = array[2];

        let reviewsCell = row.insertCell();
        reviewsCell.textContent = array[3];
        laptop.reviews = array[3];

        let linkCell = row.insertCell();
        let linkAnchor = document.createElement('a');
        linkAnchor.href = array[1];
        linkAnchor.setAttribute("target", "_blank");
        linkAnchor.innerHTML = '<i class="fa-solid fa-arrow-up-right-from-square"></i>';
        linkCell.appendChild(linkAnchor);
        laptop.link = array[1];

        let locationCell = row.insertCell();
        locationCell.textContent = array[4];
        laptop.location = array[4];

        // console.log(laptop);
        laptops_data.push(laptop);
      });
      console.log(laptops_data);
    }

    function applyFilters() {
      const filterBy = document.getElementById('filterBy').value;

      let filteredData = laptops_data; // Remove header row

      if (filterBy === 'name') {
        filteredData = filteredData.sort((a, b) => a[0].localeCompare(b[0])); // Sort by name
      } else if (filterBy === 'price') {
        filteredData = filteredData.sort((a, b) => {
          const priceA = parseFloat(a[2].replace(/[^\d.]/g, ''));
          const priceB = parseFloat(b[2].replace(/[^\d.]/g, ''));
          return priceA - priceB; // Sort by price (low to high)
        });
      } else if (filterBy === 'reviews') {
        filteredData = filteredData.sort((a, b) => parseFloat(b[3]) - parseFloat(a[3])); // Sort by reviews (highest to lowest)
      }

      // Display the filtered data
      let table = document.getElementById('output');
      table.innerHTML = "";
      filteredData.forEach((array, index) => {
        let row = table.insertRow();
        row.classList.add("cursor-pointer", "border-b", "border-gray-400", "h-10", "hover:border-b-2");

        let serialNoCell = row.insertCell();
        serialNoCell.classList.add("font-bold");
        serialNoCell.textContent = index + 1;

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
            } else {
              showToast('Data Refreshed, Press Laptops Button');
            }
          })
          .catch(error => {
            console.error(error);
          });
        fetched_dataset_laptop = false;
      } else if (fetched == 'Mobile') {
        fetch('http://127.0.0.1:5050/scraped-data-mobiles')
          .then(response => {
            if (!response.ok) {
              throw new Error('Network response was not OK');
            } else {
              showToast('Data Refreshed, Press Mobiles Button');
            }
          })
          .catch(error => {
            console.error(error);
          });
        fetched_dataset_mobile = false;
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