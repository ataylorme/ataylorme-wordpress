const fs = require('fs');

const Octokit = require("@octokit/rest");

const octokit = new Octokit({
  auth: process.env.GITHUB_TOKEN
});

const lighthouseConstants = require("./lighthouse-constants");

const devData = JSON.parse(fs.readFileSync(lighthouseConstants.devJSONFile));
const referenceData = JSON.parse(fs.readFileSync(lighthouseConstants.referenceJSONFile));

const devPerformanceScore = (devData.lhr.categories.performance.score * 100);
const livePerformanceScore = (referenceData.lhr.categories.performance.score * 100);
const devBestPracticeScore = (devData.lhr.categories['best-practices'].score * 100);
const liveBestPracticeScore = (referenceData.lhr.categories['best-practices'].score * 100);
const devSeoScore = (devData.lhr.categories.seo.score * 100);
const liveSeoScore = (referenceData.lhr.categories.seo.score * 100);
const devAccessibilityScore = (devData.lhr.categories.accessibility.score * 100);
const liveAccessibilityScore = (referenceData.lhr.categories.accessibility.score * 100);

const devReportURL = `${process.env.ARTIFACTS_DIR_URL}/lighthouse_data/lighthouse-audit-dev.html`;
const liveReportURL = `${process.env.ARTIFACTS_DIR_URL}/lighthouse_data/lighthouse-audit-reference.html`;

function round(v) {
  return (v >= 0 || -1) * Math.round(Math.abs(v));
}

const scoresToReport = [
  {
    description: "Performance Score",
    dev: devPerformanceScore,
    live: livePerformanceScore,
    difference: round(devPerformanceScore - livePerformanceScore)
  },
  {
    description: "Best Practice Score",
    dev: devBestPracticeScore,
    live: liveBestPracticeScore,
    difference: round(devBestPracticeScore - liveBestPracticeScore)
  },
  {
    description: "SEO Score",
    dev: devSeoScore,
    live: liveSeoScore,
    difference: round(devSeoScore - liveSeoScore)
  },
  {
    description: "Accessibility Score",
    dev: devAccessibilityScore,
    live: liveAccessibilityScore,
    difference: round(devAccessibilityScore - liveAccessibilityScore)
  },
];

let pullRequestMessage = `
Lighthouse Audit Results:

| Description | Live | pr-${process.env.PR_NUMBER} | Difference |
| --- | --- | --- | --- |`;

scoresToReport.map(scoreObj => {
  pullRequestMessage += `
| ${scoreObj.description} | \`${scoreObj.live}\` | \`${scoreObj.dev}\` | \`${scoreObj.difference}\` |`
});

pullRequestMessage += `

Lighthouse Audit Reports:

- [\`pr-${process.env.PR_NUMBER}\` HTML Report](${liveReportURL})
- [\`ataylor.me\` HTML Report](${devReportURL})
`;

async function getPullRequestLighthouseComments() {
  let response;
  try {
    response = await octokit.issues.listComments({
      owner: process.env.CIRCLE_PROJECT_USERNAME,
      repo: process.env.CIRCLE_PROJECT_REPONAME,
      issue_number: process.env.PR_NUMBER,
      per_page: 100
    });
  } catch (err) {
    console.log(err);
  }

  return response.data.filter((commentObj) => {
    return (
      commentObj.body.includes("lighthouse_data") &&
      commentObj.body.toLowerCase().includes("lighthouse audit results")
    );
  });
}

async function deleteCommentOnPullRequest(commentID) {
  try {
    octokit.issues.deleteComment({
      owner: process.env.CIRCLE_PROJECT_USERNAME,
      repo: process.env.CIRCLE_PROJECT_REPONAME,
      comment_id: commentID
    });
  } catch (err) {
    console.log(err);
  }
}

(async () => {
  const lighthouseComments = await getPullRequestLighthouseComments();

  if (lighthouseComments.length) {
    console.log(`Found ${lighthouseComments.length} LightHouse comments`);
    await Promise.all(lighthouseComments.map(
      (comment) => deleteCommentOnPullRequest(comment.id)
    ));
  }

  await octokit.issues.createComment({
    owner: process.env.CIRCLE_PROJECT_USERNAME,
    repo: process.env.CIRCLE_PROJECT_REPONAME,
    issue_number: process.env.PR_NUMBER,
    body: pullRequestMessage
  });

  process.exit(0);
})();