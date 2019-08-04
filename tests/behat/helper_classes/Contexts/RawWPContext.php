<?php
declare(strict_types=1);

namespace ataylorme\WordHatHelpers\Contexts;

use PaulGibbs\WordpressBehatExtension\Context\RawWordpressContext;
use PaulGibbs\WordpressBehatExtension\Context\Traits\UserAwareContextTrait;
use PaulGibbs\WordpressBehatExtension\PageObject\LoginPage;
use Behat\Mink\Exception\ExpectationException;
use RuntimeException;
use FailAid\Context\FailureContext;

/**
 * Define WordPress specific helper methods.
 */
class RawWPContext extends RawWordpressContext
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
     * Get the WordPress admin URL
     *
     * @return string the Mink base_url with /wp-admin/index.php appended
     */
    protected function getAdminURL()
    {
        return $this->getWordpressParameter('site_url') . '/wp-admin/index.php';
    }

    /**
     * Get the WordPress admin base URL
     *
     * @return string the Mink base_url with /wp-admin/index.php appended
     */
    protected function getAdminBaseURL()
    {
        return $this->getWordpressParameter('site_url');
    }

    /**
     * Get the WordPress front end URL
     *
     * @return string the Mink base_url
     */
    protected function getFrontendURL()
    {
        return $this->getMinkParameter('base_url');
    }

    /**
     * Get the stored previous URL
     *
     * @return string the previous URL set with 
     */
    protected function getPreviousURL()
    {
        if( null === $this->previous_url ) {
            $this->previous_url = ( $this->loggedIn() ) ? $this->getAdminURL() : $this->getFrontendURL();
        };
        return $this->previous_url;
    }

    /**
     * Set the previous URL to the current session URL
     *
     * @return void
     */
    protected function setPreviousURL()
    {
        // Set previous URL to the current URL
        $this->previous_url = $this->getSession()->getCurrentUrl();
    }

    /**
     * Go to the stored previous URL
     *
     * @return void
     */
    protected function goToPreviousURL()
    {
        // Go back to the previous URL
        $this->getSession()->visit($this->getPreviousURL());
    }

    /**
     * Gets the WordPress admin user passed to WordHat
     *
     * @return array The WordHat WordPress admin user
     */
    protected function getAdminUser()
    {
        $found_user = null;
        $users      = $this->getWordpressParameter('users');

        foreach ($users as $user) {
            if (in_array('administrator', $user['roles'], true)) {
                $found_user = $user;
                break;
            }
        }

        if ($found_user === null) {
            throw new RuntimeException("No admin users found.");
        }

        return $found_user;
    }

    /**
     * Log into WordPress as an admin
     *
     * @throws \RuntimeException
     * 
     * @return void
     */
    protected function loginAsWordPressAdmin()
    {
        // Get the admin user
        $found_user = $this->getAdminUser();
        FailureContext::addState('username', $found_user['username']);

        // Stash the session and driver
        $session = $this->getSession();
        $driver = $session->getDriver();

        // Stash the current URL to redirect to
        $previous_url = $session->getCurrentUrl();
        FailureContext::addState('previous_url', $previous_url);

        // Logout if logged in
        if ($this->loggedIn()) {
            $this->logOut();
        }

        // Go to the login page
        $this->visitPath(
            $this->getAdminBaseURL() .
            '/wp-login.php?redirect_to=' .
            urlencode($previous_url)
        );

        // Get the page
        $page = $session->getPage();

        // Accept the cookie notice if needed
        $cookie_notice_button = $page->find('css', '#wp-gdpr-cookie-notice .wp-gdpr-cookie-notice-button');
        if( null !== $cookie_notice_button ) {
            $cookie_notice_button->press();
            // Wait for the cookie notice element to be hidden, giving up after 5 seconds.
            $session->wait(
                5000,
                "null !== document.getElementById('wp-gdpr-cookie-notice') && true === document.getElementById('wp-gdpr-cookie-notice').hidden"
            );
        }

        // Fill in the login details
        $this->login_page->setUserName($found_user['username']);
        $this->login_page->setUserPassword($found_user['password']);
        $this->login_page->setRememberMe();

        // Submit the login form
        $this->login_page->submitLoginForm();

        if (! $this->loggedIn()) {
            throw new ExpectationException('The user could not be logged-in.', $driver);
        }
    }

    /**
     * Logs out of WordPress and redirect to
     * the existing URL before logging out.
     *
     * @return void
     */
    protected function logOutAndRedirect()
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

}