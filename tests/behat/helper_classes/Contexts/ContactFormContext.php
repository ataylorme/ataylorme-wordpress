<?php
declare(strict_types=1);

namespace ataylorme\WordHatHelpers\Contexts;

use ataylorme\WordHatHelpers\Contexts\RawWPContext;
use PaulGibbs\WordpressBehatExtension\Context\Traits\UserAwareContextTrait;
use PaulGibbs\WordpressBehatExtension\PageObject\LoginPage;
use RuntimeException;
use FailAid\Context\FailureContext;

/**
 * Define WPForms specific steps.
 */
class ContactForm extends RawWPContext
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
     * Go to the contact page
     * Example: Given I am on the contact page
     *
     * @Given I am on the contact page
     */
    public function goToContactPage()
    {
        $this->getSession()->visit($this->getFrontendURL() . '/contact');
    }

    /**
     * Sets the contact form first name field
     * Example: When I set the contact form first name to "Andrew"
     *
     * @When I set the contact form first name to :first_name
     * 
     * @param string $first_name
     */
    public function fillContactFormFirstNameField(string $first_name)
    {
        $this->getSession()->getPage()->fillField('wpforms-117-field_0', $first_name);
    }

    /**
     * Sets the contact form last name field
     * Example: When I set the contact form last name to "Taylor"
     *
     * @When I set the contact form last name to :last_name
     * 
     * @param string $last_name
     */
    public function fillContactFormLastNameField(string $last_name)
    {
        $this->getSession()->getPage()->fillField('wpforms-117-field_0-last', $last_name);
    }

    /**
     * Sets the contact form email field
     * Example: When I set the contact form email to "andrew@pantheon.io"
     *
     * @When I set the contact form email to :email
     * 
     * @param string $email
     */
    public function fillContactFormEmailField(string $email)
    {
        $this->getSession()->getPage()->fillField('wpforms-117-field_1', $email);
    }

    /**
     * Sets the contact form message field
     * Example: When I set the contact form message to "Something cool"
     *
     * @When I set the contact form message to :message
     * 
     * @param string $message
     */
    public function fillContactFormMessageField(string $message)
    {
        $this->getSession()->getPage()->fillField('wpforms-117-field_2', $message);
    }

    /**
     * Submit the contact form
     * Example: When I submit the contact form
     *
     * @When I submit the contact form
     */
    public function submitContactForm()
    {
        $session = $this->getSession();
        $page = $session->getPage();
        $page->pressButton('wpforms-submit-117');
        // Looks for the '#wpforms-confirmation-117' element, giving up after 5 seconds.
        $session->wait( 5000, "document.getElementById('wpforms-confirmation-117')" );
    }

}