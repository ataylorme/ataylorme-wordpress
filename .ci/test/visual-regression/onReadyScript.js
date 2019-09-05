module.exports = async (page, scenario, vp) => {
    const cookieButtonSelector = 'button.wp-gdpr-cookie-notice-button';
    try {
        await page.waitForSelector(cookieButtonSelector, { timeout: 1500 })
        await page.click(cookieButtonSelector)
    } catch (error) {
        console.log("The cookie notice did not appear.")
    }

    await page.evaluate(_ => {
        window.scrollBy(0, window.innerHeight);
    });

    await page.waitForNavigation({ waitUntil: 'networkidle0' });
    // await page.waitFor(1500);
};