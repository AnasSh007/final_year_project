const createCsvWriter = require("csv-writer").createObjectCsvWriter;
const puppeteer = require("puppeteer");
const express = require("express");
const app = express();
const port = 5050;

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

app.get("/scraped-data", (req, res) => {
  const getLapptops = async () => {
    const browser = await puppeteer.launch({
      headless: false,
      defaultViewport: null,
    });
    const page = await browser.newPage();
    await page.goto(
      "https://www.daraz.pk/catalog/?q=laptop&_keyori=ss&from=input&spm=a2a0e.home.search.go.35e340764jHKen",
      {
        waitUntil: "domcontentloaded",
      }
    );
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
        const laptopLocationElement = laptop.querySelector(".location--eh0Ro");
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

    // Define the file path and name
    const filePath = "../laptops.csv";
    const fs = require("fs");
    // Check if the file exists
    if (fs.existsSync(filePath)) {
      // Delete the file
      fs.unlink(filePath, (err) => {
        if (err) {
          console.error("Error deleting file:", err);
        } else {
          console.log("File deleted successfully");
        }
      });
    } else {
      console.log("File does not exist");
    }
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
    res.sendStatus(200);
    await browser.close();
  };
  getLapptops();
});

app.get("/scraped-data-mobiles", (req, res) => {
  const getLapptops = async () => {
    const browser = await puppeteer.launch({
      headless: false,
      defaultViewport: null,
    });
    const page = await browser.newPage();
    await page.goto(
      "https://www.daraz.pk/catalog/?q=mobile&_keyori=ss&from=input&spm=a2a0e.home.search.go.35e34076BxjXSR",
      {
        waitUntil: "domcontentloaded",
      }
    );
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
        const mobileLocationElement = mobile.querySelector(".location--eh0Ro");
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

    // Define the file path and name
    const filePath = "../mobiles.csv";

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
    res.setHeader("Cache-Control", "no-cache, no-store, must-revalidate");
    let __dirname = "../";
    res.sendFile(path.join(__dirname, "laptops.csv"));
    res.sendStatus(200);
    await browser.close();
  };
  getLapptops();
});
