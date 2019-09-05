function waitForNetworkIdle(page, timeout, maxInflightRequests = 0) {
    page.on('request', onRequestStarted);
    page.on('requestfinished', onRequestFinished);
    page.on('requestfailed', onRequestFinished);

    let inflight = 0;
    let fulfill;
    let promise = new Promise(x => fulfill = x);
    let timeoutId = setTimeout(onTimeoutDone, timeout);
    return promise;

    function onTimeoutDone() {
        page.removeListener('request', onRequestStarted);
        page.removeListener('requestfinished', onRequestFinished);
        page.removeListener('requestfailed', onRequestFinished);
        fulfill();
    }

    function onRequestStarted() {
        ++inflight;
        if (inflight > maxInflightRequests)
            clearTimeout(timeoutId);
    }

    function onRequestFinished() {
        if (inflight === 0)
            return;
        --inflight;
        if (inflight === maxInflightRequests)
            timeoutId = setTimeout(onTimeoutDone, timeout);
    }
}

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

    await waitForNetworkIdle(page, 500, 0);
    // await page.waitFor(1500);
};