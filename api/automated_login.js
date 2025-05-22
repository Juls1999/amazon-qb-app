require("dotenv").config();
const puppeteer = require("puppeteer-extra");
const StealthPlugin = require("puppeteer-extra-plugin-stealth");

puppeteer.use(StealthPlugin());

(async () => {
  const verificationUrl = process.argv[2];
  if (!verificationUrl) {
    console.error("Missing verification URL.");
    process.exit(1);
  }

  console.log(`Starting login automation for: ${verificationUrl}`);

  const browser = await puppeteer.launch({
    headless: false,
    args: [
      "--start-maximized",
      "--disable-gpu",
      "--disable-dev-shm-usage",
      "--no-sandbox",
      "--disable-setuid-sandbox",
    ],
  });

  const page = await browser.newPage();

  try {
    await page.goto(verificationUrl, {
      waitUntil: "domcontentloaded",
      timeout: 60000,
    });

    // Wait for username field
    await page.waitForSelector('input[type="text"]', { timeout: 30000 });
    console.log("Login form loaded! Proceeding to fill in credentials.");

    // Type the username
    await page.type("#awsui-input-0", process.env.AWS_USERNAME);
    const input1 = await page.evaluate(() => {
      return document.getElementById("awsui-input-0")?.value;
    });
    console.log(`userName: ${input1}`);

    // Click Next
    const nextButton = await page.$('.awsui-button, button[type="submit"]');
    if (nextButton) {
      console.log("Clicking next button.");
      await nextButton.click();
    }

    // Wait for the password field to appear after clicking Next
    await page.waitForFunction(
      () => {
        return (
          !!document.querySelector("#awsui-input-1") ||
          !!document.querySelector('input[type="password"]')
        );
      },
      { timeout: 30000 }
    );

    // Now type the password
    await page.type("#awsui-input-1", process.env.AWS_PASSWORD);
    const input = await page.evaluate(() => {
      return document.getElementById("awsui-input-1")?.value;
    });
    console.log(`passWord: ${input}`);

    // Click Sign-In ZCZP
    const signinButton = await page.$('#password-submit-button');
    if (signinButton) {
      console.log("Clicking sign-in button.");
      await signinButton.click();
    }

    // Wait for navigation (you can fine-tune this)
    await page.waitForNavigation({ waitUntil: "networkidle2", timeout: 3000 });

    console.log("Login attempt complete.");
  } catch (err) {
    console.error("Login automation failed:", err);
  } finally {
    await browser.close();
  }
})();
