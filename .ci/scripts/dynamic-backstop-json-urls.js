// Require the node file system
var fs = require('fs');
// Stash the directory where the script was started from
var rootPath = process.cwd();
// Get the contents of the backstop.json template
var fileContents = require(rootPath + '/.ci/scripts/backstop.default.json');

// Relative URLs don't start with http
function isRelativeURL(url) {
  return !url.startsWith('http');
}

// Stash dev URL, removing any trailing slash
var devURL = process.env.DEV_SITE_URL.replace(/\/$/, "");

// Stash multidev URL, removing any trailing slash
var multidevURL = process.env.MULTIDEV_SITE_URL.replace(/\/$/, "");

// Loop through all scrnarios in the template
var newScenarios = fileContents.scenarios.map(function (scenario) {

  // If the url of the scenario is empty
  if (scenario.url.legth == 0) {
    // Set it to the multidev URL
    scenario.url = multidevURL;
    // If the url of the scenario is relative
  } else if (isRelativeURL(scenario.url)) {
    // Prepend the multidev URL
    scenario.url = multidevURL + scenario.referenceUrl;
  }

  // If the url of the reference scenario is empty
  if (scenario.referenceUrl.length == 0) {
    // Set it to the dev URL
    scenario.referenceUrl = devURL;
    // If the url of the reference scenario is relative
  } else if (isRelativeURL(scenario.referenceUrl)) {
    // Prepend the dev URL
    scenario.referenceUrl = devURL + scenario.referenceUrl;
  }

  // Return the updated scenario
  return scenario;
});

// Update the scenarios from the template with the new
// version containing the actual URLs
fileContents.scenarios = newScenarios;

// Write the backstop.json file
fs.writeFileSync(rootPath + '/.ci/scripts/backstop.json', JSON.stringify(fileContents, null, 2), function (err) {
  if (err) return console.log(err);
  console.log(rootPath + '/.ci/scripts/backstop.json created successfully!');
});
