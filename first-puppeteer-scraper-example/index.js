// import puppeteer from "puppeteer";

// const getQuotes = async () => {
//   // Start a Puppeteer session with:
//   // - a visible browser (`headless: false` - easier to debug because you'll see the browser in action)
//   // - no default viewport (`defaultViewport: null` - website page will be in full width and height)
//   const browser = await puppeteer.launch({
//     headless: false,
//     defaultViewport: null,
//   });

//   // Open a new page
//   const page = await browser.newPage();

//   // On this new page:
//   // - open the "http://quotes.toscrape.com/" website
//   // - wait until the dom content is loaded (HTML is ready)
//   await page.goto("http://quotes.toscrape.com/", {
//     waitUntil: "domcontentloaded",
//   });

//   // Get page data
//   const quotes = await page.evaluate(() => {
//     // Fetch the first element with class "quote"
//     // Get the displayed text and returns it
//     const quoteList = document.querySelectorAll(".quote");

//     // Convert the quoteList to an iterable array
//     // For each quote fetch the text and author
//     return Array.from(quoteList).map((quote) => {
//       // Fetch the sub-elements from the previously fetched quote element
//       // Get the displayed text and return it (`.innerText`)
//       const text = quote.querySelector(".text").innerText;
//       const author = quote.querySelector(".author").innerText;

//       return { text, author };
//     });
//   });

//   // Display the quotes
//   console.log(quotes);

//   await page.click(".pager > .next > a");

//   // Close the browser
//   await browser.close();
// };

// // Start the scraping
// getQuotes();

// const express = require("express");
// const app = express();
// const port = 5050;

// // Define your routes and endpoints here

// app.listen(port, () => {
//   console.log(`Server running on port ${port}`);
// });

// const cors = require("cors");
// app.use(
//   cors({
//     origin: "http://127.0.0.1:5501", // or '*' for all origins
//   })
// );

// app.get("/scraped-data", (req, res) => {
//   const CryptoJS = require("crypto-js");
//   const encrypt = (text) => {
//     return CryptoJS.enc.Base64.stringify(CryptoJS.enc.Utf8.parse(text));
//   };
//   const getLapptops = async () => {
//     const puppeteer = require("puppeteer");
//     const browser = await puppeteer.launch({
//       headless: true,
//       // defaultViewport: null,
//     });
//     const page = await browser.newPage();
//     await page.goto("https://www.olx.com.pk/lahore_g4060673/q-laptop", {
//       waitUntil: "domcontentloaded",
//     });
//     const laptops = await page.evaluate(() => {
//       const laptopList = document.querySelectorAll("._7e3920c1");
//       return Array.from(laptopList).map((laptop) => {
//         const laptopName = laptop.querySelector(".a5112ca8").innerText;
//         const laptopPrice = laptop.querySelector("._95eae7db").innerText;
//         const location = laptop.querySelector("._424bf2a8").innerText;
//         const link = laptop.querySelector("a[href]").href;
//         return { laptopName, laptopPrice, location, link };
//       });
//     });

//     laptops.map((obj) => {
//       obj.id = encrypt(obj.laptopName);
//     });

//     console.log(laptops);
//     res.send(laptops);

//     // await page.click("._95dae89d > ._5fd7b300");
//     await browser.close();
//   };
//   getLapptops();
// });
