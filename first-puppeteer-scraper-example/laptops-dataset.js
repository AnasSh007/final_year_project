const createCsvWriter = require("csv-writer").createObjectCsvWriter;
const puppeteer = require("puppeteer");
const express = require("express");
const app = express();
const port = 5051;

// Define your routes and endpoints here

app.listen(port, () => {
  console.log(`Server running on port ${port}`);
});

const cors = require("cors");
app.use(
  cors({
    origin: "*", // or '*' for all origins
  })
);

// function sleep(milliseconds) {
//   return new Promise((resolve) => setTimeout(resolve, milliseconds));
// }

app.get("/laptops-data-set", (req, res) => {
  const getLapptops = async () => {
    const browser = await puppeteer.launch({
      headless: false,
      defaultViewport: null,
    });
    const page = await browser.newPage();
    await page.goto(
      "https://www.daraz.pk/catalog/?from=filter&q=laptop&price=30000-",
      {
        timeout: 0,
        waitUntil: "domcontentloaded",
      }
    );

    // Define the file path and name
    const filePath = "../laptops-dataset.csv";

    // Create a CSV writer instance
    const csvWriter = createCsvWriter({
      path: filePath,
      header: [
        { id: "laptopName", title: "Laptop Name" },
        { id: "laptopLink", title: "Laptop Link" },
        { id: "laptopPrice", title: "Laptop Price" },
        { id: "laptopReviews", title: "Laptop Reviews" },
        { id: "laptopLocation", title: "Laptop Location" },
      ],
      append: true, // Enable append mode
    });

    for (let i = 0; i < 101; i++) {
      await page.waitForNavigation({ timeout: 0 });
      const laptops = await page.evaluate(() => {
        const laptopList = document.querySelectorAll(".gridItem--Yd0sa");
        return Array.from(laptopList).map((laptop) => {
          const laptopAnchor = laptop.querySelector(".title--wFj93 a");
          const laptopName = laptopAnchor ? laptopAnchor.innerText : "";
          const laptopLink = laptopAnchor ? laptopAnchor.href : "";
          const laptopPriceElement = laptop.querySelector(".currency--GVKjl");
          const laptopPrice = laptopPriceElement
            ? laptopPriceElement.innerText
            : "";
          const laptopReviewsElement = laptop.querySelector(
            ".rating__review--ygkUy"
          );
          const laptopReviews = laptopReviewsElement
            ? laptopReviewsElement.innerText
            : "";
          const laptopLocationElement =
            laptop.querySelector(".location--eh0Ro");
          const laptopLocation = laptopLocationElement
            ? laptopLocationElement.innerText
            : "";
          return {
            laptopName,
            laptopLink,
            laptopPrice,
            laptopReviews,
            laptopLocation,
          };
        });
      });

      // Write the laptops array to the CSV file
      csvWriter
        .writeRecords(laptops)
        .then(() => {
          console.log("CSV file saved successfully.");
        })
        .catch((err) => {
          console.error("Error writing CSV file:", err);
        });

      console.log(laptops);
      // res.send(laptops);
      await page.click(".ant-pagination-next > a");
    }
    res.sendStatus(200);
    await browser.close();
  };
  getLapptops();
});

app.get("/mobiles-data-set", (req, res) => {
  const getLapptops = async () => {
    const browser = await puppeteer.launch({
      headless: false,
      defaultViewport: null,
    });
    const page = await browser.newPage();
    await page.goto(
      "https://www.daraz.pk/catalog/?from=filter&q=mobile&price=20000-",
      {
        timeout: 0,
        waitUntil: "domcontentloaded",
      }
    );

    // Define the file path and name
    const filePath = "../mobiles-dataset.csv";

    // Create a CSV writer instance
    const csvWriter = createCsvWriter({
      path: filePath,
      header: [
        { id: "mobileName", title: "mobile Name" },
        { id: "mobileLink", title: "mobile Link" },
        { id: "mobilePrice", title: "mobile Price" },
        { id: "mobileReviews", title: "mobile Reviews" },
        { id: "mobileLocation", title: "mobile Location" },
      ],
      append: true, // Enable append mode
    });

    for (let i = 0; i < 101; i++) {
      await page.waitForNavigation({ timeout: 0 });
      const mobiles = await page.evaluate(() => {
        const mobileList = document.querySelectorAll(".gridItem--Yd0sa");
        return Array.from(mobileList).map((mobile) => {
          const mobileAnchor = mobile.querySelector(".title--wFj93 a");
          const mobileName = mobileAnchor ? mobileAnchor.innerText : "";
          const mobileLink = mobileAnchor ? mobileAnchor.href : "";
          const mobilePriceElement = mobile.querySelector(".currency--GVKjl");
          const mobilePrice = mobilePriceElement
            ? mobilePriceElement.innerText
            : "";
          const mobileReviewsElement = mobile.querySelector(
            ".rating__review--ygkUy"
          );
          const mobileReviews = mobileReviewsElement
            ? mobileReviewsElement.innerText
            : "";
          const mobileLocationElement =
            mobile.querySelector(".location--eh0Ro");
          const mobileLocation = mobileLocationElement
            ? mobileLocationElement.innerText
            : "";
          return {
            mobileName,
            mobileLink,
            mobilePrice,
            mobileReviews,
            mobileLocation,
          };
        });
      });

      // Write the mobiles array to the CSV file
      csvWriter
        .writeRecords(mobiles)
        .then(() => {
          console.log("CSV file saved successfully.");
        })
        .catch((err) => {
          console.error("Error writing CSV file:", err);
        });

      console.log(mobiles);
      // res.send(mobiles);
      await page.click(".ant-pagination-next > a");
    }
    res.sendStatus(200);
    await browser.close();
  };
  getLapptops();
});
