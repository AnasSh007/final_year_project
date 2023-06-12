<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.js"></script>
  <title>Document</title>
</head>

<body>
  <button onclick="getCSV()">Get Data</button>
  <button onclick="getLaptops()">Click Me</button>
  <script>
    const encrypt = (text) => {
      return CryptoJS.enc.Base64.stringify(CryptoJS.enc.Utf8.parse(text));
    };
    async function getLaptops() {
      await fetch("http://localhost:5050/scraped-data", {
        // mode: "no-cors",
        // method: "get",
        // headers: {
        //   "Content-Type": "application/json",
        // },
        // body: JSON.stringify(),
      })
        .then((response) => response.json())
        .then((json) => {
          // json.map((obj) => {
          //   obj.id = encrypt(obj.laptopName);
          //   // console.log(obj.laptopName);
          //   // console.log(obj);
          // });
          console.log(json);
        })
        .catch((e) => {
          console.log("error occured = " + e);
        });
    }
    function getCSV() {
      fetch('data.csv')
        .then(response => response.text())
        .then(csv => {
          processCSV(csv);
        })
        .catch(error => {
          console.error('Error fetching CSV file:', error);
        });

      function processCSV(csv) {
        const lines = csv.split('\n');

        for (let i = 0; i < lines.length; i++) {
          const values = lines[i].split(',');

          // Process each value
          for (let j = 0; j < values.length; j++) {
            const value = values[j];

            // Perform operations on each value
            console.log(value);
          }
        }
      }

    }
  </script>
</body>

</html>