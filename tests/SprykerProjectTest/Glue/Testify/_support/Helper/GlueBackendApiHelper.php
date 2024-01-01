<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerProjectTest\Glue\Testify\Helper;

use Codeception\Stub;
use Codeception\Util\HttpCode;
use SprykerProject\Glue\GlueApplication\Bootstrap\GlueBackendApiBootstrap;
use SprykerProject\Glue\GlueApplication\GlueApplicationDependencyProvider;
use SprykerProject\Glue\GlueApplication\GlueApplicationFactory;
use Spryker\Glue\Kernel\Container;
use Spryker\Shared\Application\ApplicationInterface;
use SprykerTest\Glue\Testify\Helper\GlueBackendApiHelper as SprykerGlueBackendApiHelper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GlueBackendApiHelper extends SprykerGlueBackendApiHelper
{
    /**
     * @param array<mixed, mixed>|string $parameters
     */
    protected function executeRequest(string $url, string $method, array $parameters = []): Response
    {
        $request = Request::create($url, $method, $parameters, [], [], [], $parameters !== [] ? json_encode($parameters, JSON_PRESERVE_ZERO_FRACTION | JSON_THROW_ON_ERROR) : null);

        $request->headers->add($this->headers);

        // Set the predefined Request so that the GlueBackendApiApplication can pick it up instead of creating an empty Request.
        $this->getRequestBuilderStub()->setRequest($request);

        // Run the mocked GlueBackendApiApplication.
        $this->getGlueBackendApiApplication()->run();

        // Get the response that was created from the GlueBackendApiApplication.
        $response = $this->getHttpSenderStub()->getResponse();

        $this->persistLastConnection($request, $response);

        return $response;
    }

    protected function getGlueBackendApiApplication(): ApplicationInterface
    {
        /** @var \Spryker\Glue\GlueApplication\GlueApplicationFactory $glueApplicationFactory */
        $glueApplicationFactory = Stub::make(GlueApplicationFactory::class, [
            'createHttpRequestBuilder' => $this->getRequestBuilderStub(),
            'createHttpSender' => $this->getHttpSenderStub(),
            'getConfig' => $this->getConfigHelper()->getModuleConfig('GlueApplication'),
        ]);

        $glueApplicationDependencyProvider = new GlueApplicationDependencyProvider();
        $glueApplicationFactory->setContainer(
            $glueApplicationDependencyProvider->provideDependencies(new Container()),
        );

        return (new GlueBackendApiBootstrap())
            ->setFactory($glueApplicationFactory)
            ->boot();
    }

    /**
     * @param int $code
     *
     * @return void
     */
    public function seeResponseCodeIs(int $code): void
    {
        $failureMessage = sprintf(
            'Expected HTTP Status Code: %s. Actual Status Code: %s. Response: %s',
            HttpCode::getDescription($code),
            HttpCode::getDescription($this->getResponse()->getStatusCode()),
            $this->getResponse(),
        );
        $this->assertSame($code, $this->getResponse()->getStatusCode(), $failureMessage);
    }

    public function seeResponseContainsErrorMessage(string $expectedErrorMessage): void
    {
        $response = json_decode($this->getResponse()->getContent(), true);
        if (!isset($response['errors'])) {
            $this->fail('Response does not contain errors.');
        }

        $foundMessage = false;

        $errorMessages = [];

        foreach ($response['errors'] as $error) {
            if ($error['message'] === $expectedErrorMessage) {
                $foundMessage = true;

                break;
            }

            $errorMessages[] = $error['message'];
        }

        $this->assertTrue(
            $foundMessage,
            sprintf('Expected to see the error message "%s" in the response, but it was not found. Error messages: "%s"', $expectedErrorMessage, implode('', $errorMessages)),
        );
    }

    /**
     * Overridden to not throw an exception when we are on project level and do not need to set plugins manually.
     *
     * @return array<\Spryker\Glue\GlueJsonApiConventionExtension\Dependency\Plugin\JsonApiResourceInterface>
     */
    protected function getJsonApiResourcePlugins(): array
    {
        if ($this->jsonApiResourcePlugins === []) {
            return [];
        }

        return $this->jsonApiResourcePlugins;
    }
}
