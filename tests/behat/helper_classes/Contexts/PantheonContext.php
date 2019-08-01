<?php
declare(strict_types=1);

namespace ataylorme\WordHatHelpers\Contexts;

use ataylorme\WordHatHelpers\Contexts\RawWPContext;
use PaulGibbs\WordpressBehatExtension\Context\Traits\UserAwareContextTrait;
use PaulGibbs\WordpressBehatExtension\PageObject\LoginPage;
use RuntimeException;
use FailAid\Context\FailureContext;

/**
 * Define Pantheon specific steps.
 */
class PantheonContext extends RawWPContext
{
    use UserAwareContextTrait;

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
            $session->visit($this->getMinkParameter('base_url'));
        }
    }

    /**
     * Clear Pantheon page cache.
     *
     * Example: When the Pantheon cache is cleared
     * Example: Given the Pantheon cache has been cleared
     * Example: And the Pantheon cache has been cleared
     *
     * @When the Pantheon cache is cleared
     * @Given the Pantheon cache has been cleared
     * @And the Pantheon cache has been cleared
     */
    public function clearPantheonCache()
    {

        // Get the session
        $session = $this->getSession();

        // Get the current page from the session
        $page = $session->getPage();

        // Are we currently logged in?
        $logged_in = $this->loggedIn();

        // If logged in
        if( $logged_in ) {
            $clear_cache_link = $page->find('css', '#wp-admin-bar-clear-page-cache > a');
            // Attempt to use the clear cache button in the toolbar
            if( null !== $clear_cache_link ) {
                // If the clear cache button was used, we are done here
                $clear_cache_link->click();
                return;
            }
        }

        // Stash the current URL to redirect back to
        $this->setPreviousURL();

        // Log in as an admin if not already logged in
        if (! $logged_in) {
            $this->loginAsWordPressAdmin();
        }

        // Visit the Pantheon page cache admin page
        $this->visitPath('wp-admin/options-general.php?page=pantheon-cache');

        // Make sure that is a valid page
        $status_code = $session->getStatusCode();
        if( 200 !== $status_code ) {
            throw new \Exception(
                "Unable to visit the Pantheon page cache options page"
            );
        }

        // Find the clear cache button
        $submit_buttons = $page->findAll('css', '#submit');

        $clearCacheButton = null;

        foreach( $submit_buttons as $submit_button ) {
            if ( $submit_button->getValue() === 'Clear Cache' ) {
                $clearCacheButton = $submit_button;
            }
        }

        // Error if it is not found
        if ( null === $clearCacheButton ) {
            throw new \Exception(
                "Unable to clear the Pantheon cache. No clear cache button was found."
            );
        }

        // Click the clear cache button
        $clearCacheButton->click();

        // Get the current URL
        $current_url = $this->getSession()->getCurrentUrl();

        // Confirm the cache clear URL
        if( false === stripos( $current_url, 'cache-cleared=true') ) {
            throw new \Exception(
                "Unable to clear the Pantheon cache"
            );
        }

        // If we weren't previously logged in, log back out
        if (! $logged_in) {
            $this->logOut();
        }

        // Go back to the previous URL
        $this->goToPreviousURL();

    }

}