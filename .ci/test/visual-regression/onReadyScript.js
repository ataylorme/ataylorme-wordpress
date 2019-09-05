module.exports = async (page, scenario, vp) => {
    await page.evaluate(_ => {
        window.scrollBy(0, window.innerHeight);
    });
};