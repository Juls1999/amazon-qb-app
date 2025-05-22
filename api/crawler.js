// 🛡️ Puppeteer with stealth plugin to avoid bot detection
const puppeteer = require("puppeteer-extra");
const StealthPlugin = require("puppeteer-extra-plugin-stealth");
puppeteer.use(StealthPlugin());

// 📦 Node.js built-in modules
const fs = require("fs");
const path = require("path");
const { URL } = require("url");

// 🧠 In-memory sets and queues for tracking visited pages and pages to visit
const visited = new Set();
const queue = [];
let pageCounter = 1;

// 🎭 Rotate user agents to simulate different browsers/devices
const userAgents = [
  "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36",
  "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/15.1 Safari/605.1.15",
];

// 🧹 Normalize URL: removes query strings and trailing slashes for consistency
function normalizeUrl(url) {
  const u = new URL(url);
  return u.origin + u.pathname.replace(/\/$/, "");
}

// 🧼 Replace invalid filename characters with underscores
function sanitizeFilename(title) {
  return title.replace(/[<>:"\/\\|?*]+/g, "_").trim();
}

// 🔁 Attempt to navigate a page with retry logic
async function tryNavigate(page, url, retries = 3) {
  for (let i = 0; i < retries; i++) {
    try {
      await page.goto(url, { waitUntil: "networkidle2", timeout: 60000 });
      return;
    } catch (err) {
      console.warn(`🔁 Retry ${i + 1} for ${url}: ${err.message}`);
      await new Promise((res) => setTimeout(res, 2000));
    }
  }
  throw new Error(`Failed to load after ${retries} retries`);
}

// 🕷️ Main crawler logic for each page
async function crawlPage(browser, pageUrl, domain) {
  const normalizedUrl = normalizeUrl(pageUrl);
  if (visited.has(normalizedUrl)) return; // ⛔ Skip already visited pages
  visited.add(normalizedUrl); // ✅ Mark as visited

  try {
    const page = await browser.newPage();

    // Set a random user agent to mimic different users
    await page.setUserAgent(
      userAgents[Math.floor(Math.random() * userAgents.length)]
    );

    // Navigate to the page
    await tryNavigate(page, pageUrl);

    // Wait for essential content areas to appear
    await page.waitForSelector("main, article, body", {
      visible: true,
      timeout: 60000,
    });

    // Delay to allow content like JavaScript-rendered DOM to fully load
    await new Promise((res) => setTimeout(res, 2000));

    // Wait up to 10s for the article title
    await page.waitForSelector("h1", { visible: true, timeout: 10000 }).catch(() => null);

    // Extract <h1> for article title
    const articleTitle = await page
      .$eval("h1", (el) => el.innerText.trim())
      .catch(() => null);

    // Construct sanitized filename
    const sanitizedTitle = sanitizeFilename(articleTitle || `untitled_${pageCounter++}`);
    const urlPart = sanitizeFilename(new URL(pageUrl).hostname);

    // Set file name with deduplication if file already exists
    let fileName = `${urlPart}_${sanitizedTitle}.json`;
    let filePath = path.join(__dirname, "output", fileName);
    let suffix = 1;
    while (fs.existsSync(filePath)) {
      fileName = `${urlPart}_${sanitizedTitle}_${suffix++}.json`;
      filePath = path.join(__dirname, "output", fileName);
    }

    // 📄 Extract structured content (headings, paragraphs, lists, links)
    const structuredContent = await page.evaluate(() => {
      const content = [];
      const elements = document.querySelectorAll("h1, h2, h3, h4, h5, h6, p, li, a");

      elements.forEach((el) => {
        const text = el.innerText.trim();
        if (!text) return;

        const tag = el.tagName;
        if (tag.startsWith("H")) {
          content.push({ type: "heading", level: tag, text });
        } else if (tag === "LI") {
          content.push({ type: "list-item", text });
        } else if (tag === "A") {
          content.push({ type: "link", href: el.href, text });
        } else {
          content.push({ type: "paragraph", text });
        }
      });

      return content;
    });

    // Save extracted data
    const structuredData = {
      article_title: articleTitle,
      url: pageUrl,
      content: structuredContent,
    };

    fs.writeFileSync(filePath, JSON.stringify(structuredData, null, 2));
    console.log(`✅ Saved: ${fileName} from ${pageUrl}`);

    // 🔗 Find all internal links on the page
    const links = await page.$$eval("a", (as) =>
      as.map((a) => a.href).filter((href) => href.startsWith("http"))
    );

    // Add unvisited internal links to queue
    for (const link of links) {
      try {
        const url = new URL(link);
        const normalized = normalizeUrl(link);
        if (url.hostname === domain && !visited.has(normalized) && !queue.includes(normalized)) {
          queue.push(normalized);
        }
      } catch (err) {
        console.error(`❌ Invalid URL in links: ${err.message}`);
      }
    }

    await page.close(); // 🧹 Clean up the page
  } catch (err) {
    console.error(`❌ Failed to load ${pageUrl}: ${err.message}`);
  }
}

// 🚀 Start crawling from the seed URL
(async () => {
  const seedURL = "https://www.crystalvoice.com.sg/";
  const seedDomain = new URL(seedURL).hostname;

  const outputDir = path.join(__dirname, "output");
  if (!fs.existsSync(outputDir)) {
    fs.mkdirSync(outputDir); // Ensure output directory exists
  }

  const normalizedSeed = normalizeUrl(seedURL);
  queue.push(normalizedSeed);

  // Launch Puppeteer browser
  const browser = await puppeteer.launch({
    headless: true,
    args: ["--no-sandbox"],
  });

  // 📡 Loop through all pages in the queue
  while (queue.length > 0) {
    const nextURL = queue.shift();
    console.log("🌐 Visiting:", nextURL);
    await crawlPage(browser, nextURL, seedDomain);
    await new Promise((r) => setTimeout(r, 3000)); // 🌙 Throttle crawling speed
  }

  await browser.close(); // 🛑 Close browser when done
})();
