const fs = require('fs');

const lighthouseConstants = require("./lighthouse-constants");

const devData = JSON.parse(fs.readFileSync(lighthouseConstants.devJSONFile));
const referenceData = JSON.parse(fs.readFileSync(lighthouseConstants.referenceJSONFile));


test("The performance score is greater than 90", () => {
  expect(devData.lhr.categories.performance.score)
  .toBeGreaterThanOrEqual(0.9)
});

test(`The performance score drops no more than 1%`, () => {
  expect(devData.lhr.categories.performance.score)
    .toBeGreaterThanOrEqual(referenceData.lhr.categories.performance.score - 0.01)
});

test("The best practices score is greater than 90", () => {
  expect(devData.lhr.categories['best-practices'].score)
  .toBeGreaterThanOrEqual(0.9)
});

test("The best practices score drops no more than 1%", () => {
  expect(devData.lhr.categories['best-practices'].score)
  .toBeGreaterThanOrEqual(referenceData.lhr.categories['best-practices'].score - 0.01)
});

test("The accessibility score is greater than 90", () => {
  expect(devData.lhr.categories.accessibility.score)
  .toBeGreaterThanOrEqual(0.9)
});

test("The accessibility score drops no more than 1%", () => {
  expect(devData.lhr.categories.accessibility.score)
  .toBeGreaterThanOrEqual(referenceData.lhr.categories.accessibility.score - 0.01)
});

test("The SEO score is greater than 80", () => {
  expect(devData.lhr.categories.seo.score)
  .toBeGreaterThanOrEqual(0.80)
});

test("The SEO score drops no more than 1%", () => {
  expect(devData.lhr.categories.seo.score)
  .toBeGreaterThanOrEqual(referenceData.lhr.categories.seo.score - 0.01)
});