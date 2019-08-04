<?php
declare(strict_types=1);

namespace ataylorme\WordHatHelpers\Contexts;

use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Mink\Exception\ExpectationException;

/**
 * Define Cookie Notice specific steps.
 */
class CookieNotice extends RawMinkContext
{

    protected $cookie_notice_css_id = 'wp-gdpr-cookie-notice';

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
     * The cookie notice is shown
     * Example: Given the cookie notice is shown
     *
     * @Given the cookie notice is shown
     *
     * @return void
     */
    public function cookieNoticeIsShown()
    {
        $this->assertSession()->elementTextContains(
            'css',
            '#' . $this->cookie_notice_css_id,
            'This Site Uses Cookies'
        );
    }
    
    /**
     * The cookie notice is hidden
     * Example: Given the cookie notice is hidden
     *
     * @Given the cookie notice is hidden
     *
     * @return void
     */
    public function cookieNoticeIsHidden()
    {
        $this->assertSession()->pageTextNotContains('This Site Uses Cookies');
    }

    /**
     * Accept the cookie notice
     * Example: When I accept the cookie notice
     *
     * @When I accept the cookie notice
     *
     * @return void
     */
    public function acceptCookieNotice()
    {
        $session = $this->getSession();
        $page = $session->getPage();
        $cookie_notice_button = $page->find('css', '#' . $this->cookie_notice_css_id . ' .wp-gdpr-cookie-notice-button');
        if( null === $cookie_notice_button ) {
            throw new ExpectationException(
                "Failed to accept the cookie notice. The cookie notice acceptance button was not found.",
                $session->getDriver()
            );
        }
        $cookie_notice_button->press();
        // Wait for the cookie notice element to be hidden, giving up after 5 seconds.
        $session->wait(
            5000,
            "null !== document.getElementById('" . $this->cookie_notice_css_id . "') && true === document.getElementById('" . $this->cookie_notice_css_id . "').hidden"
        );
    }

}