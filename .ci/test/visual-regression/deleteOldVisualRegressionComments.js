const Octokit = require("@octokit/rest");

const octokit = new Octokit({
  auth: process.env.GITHUB_TOKEN
});

async function getPullRequestVisualRegressionComments() {
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
      commentObj.body.includes("backstop_data") &&
      commentObj.body.toLowerCase().includes("visual regression test")
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
  const visualRegressionComments = await getPullRequestVisualRegressionComments();

  if (visualRegressionComments.length) {
    await Promise.all(visualRegressionComments.map(
      (comment) => deleteCommentOnPullRequest(comment.id)
    ));
  }

  process.exit(0);
})();