const rootPath = process.cwd();
const lighthouseDataDir = `${rootPath}/lighthouse_data/`;

module.exports = {

    // Root path is where npm run commands happen
    rootPath: rootPath,
    lighthouseDataDir: lighthouseDataDir,
    devJSONFile: `${lighthouseDataDir}/lighthouse-audit-dev.json`,
    devHTMLFile: `${lighthouseDataDir}/lighthouse-audit-dev.html`,
    referenceJSONFile: `${lighthouseDataDir}/lighthouse-audit-reference.json`,
    referenceHTMLFile: `${lighthouseDataDir}/lighthouse-audit-reference.html`,

    getDevURL: () => {
        // return 'https://ataylorme-wordpress.lndo.site';
        let devURL;

        if (process.env.CI_BRANCH == "master") {
            devURL = process.env.DEV_SITE_URL.replace(/\/$/, "");
        } else {
            devURL = process.env.MULTIDEV_SITE_URL.replace(/\/$/, "");
        }

        return devURL;
    },

    getReferenceURL: () => {
        // return 'https://dev-ataylorme-wordpress.pantheonsite.io';
        let referenceURL;

        if (process.env.CI_BRANCH == "master") {
            referenceURL = process.env.LIVE_SITE_URL.replace(/\/$/, "");
        } else {
            referenceURL = process.env.DEV_SITE_URL.replace(/\/$/, "");
        }

        return referenceURL;
    },

}