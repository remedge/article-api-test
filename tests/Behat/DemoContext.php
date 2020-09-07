<?php

declare(strict_types=1);

namespace App\Tests\Behat;

use App\DataFixtures\ArticleFixtures;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * This context class contains the definitions of the steps used by the demo
 * feature file. Learn how to get started with Behat and BDD on Behat's website.
 *
 * @see http://behat.org/en/latest/quick_start.html
 */
final class DemoContext implements Context
{
    /** @var KernelInterface */
    private $kernel;

    /** @var Response|null */
    private $response;

    private $server = [];

    private $content;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @When i send :method request to :path
     *
     * @throws \Exception
     */
    public function iSendRequestTo(string $method, string $path)
    {
        $this->response = $this->kernel->handle(Request::create(
            $path,
            $method,
            [],
            [],
            [],
            $this->server,
            $this->content
        ));
    }

    /**
     * @Then http code :httpCode should be received
     * @param string $httpCode
     */
    public function httpCodeShouldBeReceived(string $httpCode)
    {
        if ($this->response->getStatusCode() != $httpCode) {
            throw new \RuntimeException(sprintf('Response HTTP code mismatch: %s', $this->response->getStatusCode()));
        }
    }

    /**
     * @Given the :header request header is :value
     *
     * @param string $header
     * @param string $value
     * @return DemoContext
     */
    public function setRequestHeader(string $header, string $value)
    {
        $serverString = null;
        switch ($header) {
            case 'Authorization':
                $serverString = 'HTTP_AUTHORIZATION';
                break;
            case 'Content-Type':
                $serverString = 'CONTENT_TYPE';
                break;
            case 'Accept':
                $serverString = 'HTTP_ACCEPT';
                break;
        }

        $this->server[$serverString] = $value;

        return $this;
    }

    /**
     * @Given the request content is:
     *
     * @param PyStringNode $string
     * @return DemoContext
     */
    public function theRequestContentIs(PyStringNode $string)
    {
        $this->content = $string;

        return $this;
    }

    /**
     * @Then the response data parameter :parameter should be :value
     * @param $parameter
     * @param $value
     */
    public function theResponseDataParameterShouldBe($parameter, $value)
    {
        $content = json_decode($this->response->getContent(), true);
        if ($content['data'][$parameter] !== $value) {
            throw new \RuntimeException(sprintf('Result field %s mismatch: %s', $parameter, $content['data'][$parameter]));
        }
    }

    /**
     * @Given load data fixtures
     */
    public function loadDataFixtures()
    {
        $container = $this->kernel->getContainer();
        $entityManager = $container->get('doctrine.orm.default_entity_manager');

        $schemaTool = new SchemaTool($entityManager);
        $schemaTool->dropDatabase();
        $metadata = $entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool->createSchema($metadata);

        $fixture = new ArticleFixtures();
        $fixture->load($entityManager);
    }
}
