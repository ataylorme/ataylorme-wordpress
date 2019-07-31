<?php
declare(strict_types=1);

namespace ataylorme\WordHatHelpers\Contexts;

use ataylorme\WordHatHelpers\Contexts\RawWPContext;
use PaulGibbs\WordpressBehatExtension\Context\Traits\UserAwareContextTrait;
use PaulGibbs\WordpressBehatExtension\PageObject\LoginPage;
use Behat\Mink\Exception\ExpectationException;
use RuntimeException;
use FailAid\Context\FailureContext;

/**
 * Define application features from the specific context.
 */
class WordPressContext extends RawWPContext
{
    use UserAwareContextTrait;

    protected $previous_url;

    /**
     * Login form page object.
     *
     * @var LoginPage
     */
    public $login_page;

    /**
     * Constructor.
     *
     * @param LoginPage $login_page The page object representing the login page.
     */
    public function __construct(LoginPage $login_page)
    {
        parent::__construct($login_page);
        $this->login_page = $login_page;
    }

    /**
     * @BeforeStep
     */
    public function beforeStep()
    {

        // Start a session if needed
        $session = $this->getSession();
        if (! $session->isStarted() ) {
            $session->start();
        }

        // Stash the current URL
        $current_url = $session->getCurrentUrl();

        // If we aren't on a valid page
        if ('about:blank' === $current_url ) {
            // Go to the home page
            $session->visit($this->getFrontendURL());
        }
    }

    /**
     * Verify that a user is not logged in
     *
     * Example: Then I should not be logged in
     *
     * @Then /^(?:I|they) should not be logged in$/
     *
     * @throws ExpectationException
     */
    public function iShouldNotBeLoggedIn()
    {
        if( $this->loggedIn() ) {
            throw new ExpectationException(
                'A user is logged in. This should not have happened.',
                $this->getSession()->getDriver()
            );
        }
    }

    /**
     * Verify that a user is logged in
     *
     * Example: Then I should be logged in
     *
     * @Then /^(?:I|they) should be logged in$/
     *
     * @throws ExpectationException
     */
    public function iShouldBeLoggedIn()
    {
        if( ! $this->loggedIn() ) {
            throw new ExpectationException(
                'A user is not logged in. This should not have happened.',
                $this->getSession()->getDriver()
            );
        }
    }

    /**
     * Take a screenshot
     *
     * Example: And I take a Chrome screenshot
     * Example: And I take a Chrome screenshot "some-page.png"
     *
     * @Then /^(?:|I )take a Chrome screenshot "(?P<file_name>[^"]+)"$/
     * @Given I take a Chrome screenshot
     */
    public function takeScreenshot($file_name=null)
    {
        $driver = $this->getSession()->getDriver();
        $ss_path = 'behat-screenshots/' . date('Y-m-d');
        if (!file_exists($ss_path)) {
            mkdir($ss_path, 0777, true);
        }
        if ( null == $file_name ) {
            $file_name = 'screenshot-' . date('Y-m-d-H-i-s') . '.png';
        }
        $driver->captureScreenshot($ss_path . '/' . $file_name);
    }

    /**
     * Logs out of WordPress
     *
     * @return void
     */
    public function logOutAndRedirect()
    {
        // Get the session
        $session = $this->getSession();

        // Stash the current URL to redirect to
        $previous_url = $session->getCurrentUrl();

        // Logout
        $this->logOut();

        // Error if the user is still logged in
        if ( $this->loggedIn() ) {
            throw new ExpectationException(
                "Failed to log out.",
                $session->getDriver()
            );
        }

        // Go to the previous URL
        $session->visit($previous_url);

    }

    /**
     * Log into WordPress as an admin
     *
     * Example: Given I am a WordPress admin
     *
     * @Given /^(?:I am|they are) a WordPress admin$/
     *
     * @throws \RuntimeException
     * 
     * @return void
     */
    public function loggedInAsAdmin()
    {
        // Are we currently logged in?
        $logged_in = $this->loggedIn();

        // If logged in
        if( $logged_in ) {
            // Log out
            $this->logOutAndRedirect();
        }

        // Re-authenticate as an admin
        $this->loginAsWordPressAdmin();
    }

}