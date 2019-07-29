<?php

declare(strict_types=1);

namespace ataylorme\WordHatHelpers\Contexts;

use Behat\MinkExtension\Context\MinkContext;
use Behat\Mink\Exception\ExpectationException;
use FailAid\Context\FailureContext;

/**
 * Define misc context.
 */
class MiscContext extends MinkContext
{

    /**
     * Get the WordPress admin URL
     *
     * @return string the Mink base_url with /wp-admin appended
     */
    private function _getAdminURL()
    {
        return $this->getWordpressParameter('site_url') . '/wp-admin/index.php';
    }

    /**
     * Get the WordPress front end URL
     *
     * @return string the Mink base_url
     */
    private function _getFrontendURL()
    {
        return $this->getMinkParameter('base_url');
    }

    /**
     * Get headers from a URL
     *
     * @param string $url the URL to fetch headers from
     * @return array the response headers of the URL
     */
    private function _getHeaders($url)
    {
        $headers = [];
        $raw_headers = get_headers($url, 1);
        unset($raw_headers[0]);
        foreach( $raw_headers as $key => $value ) {
            $headers[strtolower($key)] = $value;
        }
        return $headers;
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
            $session->visit($this->_getFrontendURL());
        }
    }

    /**
     * Verify that the current page is HTTPS
     *
     * Example: Then the current page is HTTPS
     *
     * @Then /^the current page is (?:https|HTTPS)$/
     *
     * @throws ExpectationException
     * @return void
     */
    public function theCurrentPageIsHTTPS()
    {
        // Get the session
        $session = $this->getSession();

        // Get the current URL
        $current_url = $session->getCurrentUrl();

        // Verify the URL starts with HTTPS
        if (substr($current_url, 0, 8) !== "https://") {
            throw new ExpectationException(
                "The current URL $current_url does not start with https://",
                $this->getSession()->getDriver()
            );
        }
    }

    /**
     * Verify a response header is set
     *
     * Example: And the response header "cache-control" is set
     *
     * @Then the :header response header is set
     *
     * @param string $header the header name
     * @throws ExpectationException
     * @return void
     */
    public function theResponseHeaderIsSet($header)
    {
        // Get the session
        $session = $this->getSession();

        // Get the current URL
        $current_url = $session->getCurrentUrl();

        // Get the headers from the session
        $headers = $this->_getHeaders($current_url);
        // $headers = $session->getResponseHeaders();
        FailureContext::addState('response headers', print_r($headers, true));

        if (!isset($headers[$header])) {
            throw new ExpectationException(
                "The expected response header $header is not set",
                $this->getSession()->getDriver()
            );
        }
    }

    /**
     * Verify a response header value
     *
     * Example: And the "cache-control" response header equals "public, max-age=86400"
     *
     * @Then the :header response header equals :header_value
     *
     * @param string $header the header name
     * @param string $header_value the header value
     * @throws ExpectationException
     * @return void
     */
    public function theResponseHeaderEquals($header,$header_value)
    {
        // Get the session
        $session = $this->getSession();

        // Get the current URL
        $current_url = $session->getCurrentUrl();

        // Get the headers from the session
        $headers = $this->_getHeaders($current_url);
        // $headers = $session->getResponseHeaders();
        FailureContext::addState('response headers', print_r($headers, true));

        if (!isset($headers[$header])) {
            throw new ExpectationException(
                "The response header $header is not set",
                $this->getSession()->getDriver()
            );
        }
        $actual_header_value = $headers[$header];
        if ($header_value !== $actual_header_value) {
            throw new ExpectationException(
                "The response header $header value $header_value does not match the expected value of $actual_header_value",
                $this->getSession()->getDriver()
            );
        }
    }

    /**
     * Verify a response header value matches a pattern
     *
     * Example: And the "cache-control" response header value matches "public, max-age=86400"
     *
     * @Then the :header response header value matches :header_value_pattern
     *
     * @param string $header the header name
     * @param string $header_value_pattern regex pattern for the header value
     * @throws ExpectationException
     * @return void
     */
    public function theResponseHeaderValueMatches($header,$header_value_pattern)
    {
        // Get the session
        $session = $this->getSession();

        // Get the current URL
        $current_url = $session->getCurrentUrl();

        // Get the headers from the session
        $headers = $this->_getHeaders($current_url);
        // $headers = $session->getResponseHeaders();
        FailureContext::addState('response headers', print_r($headers, true));

        if (!isset($headers[$header])) {
            throw new ExpectationException(
                "The response header $header is not set",
                $this->getSession()->getDriver()
            );
        }
        $header_value = $headers[$header];
        if (1 !== preg_match($header_value_pattern, $header_value)) {
            throw new ExpectationException(
                "The response header $header value $header_value does not match the expected pattern of $header_value_pattern",
                $this->getSession()->getDriver()
            );
        }
    }

}