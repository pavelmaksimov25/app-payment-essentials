<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerProjectTest\Zed\Testify\Helper;

use Codeception\Lib\Framework;
use Codeception\TestInterface;
use Spryker\Shared\ErrorHandler\ErrorHandlerConstants;
use Spryker\Zed\Application\Communication\Bootstrap\BackofficeBootstrap;
use SprykerTest\Shared\Testify\Helper\ConfigHelperTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelBrowser;

class BootstrapHelper extends Framework
{
    use ConfigHelperTrait;

    public function _before(TestInterface $test): void
    {
        $this->disableWhoopsErrorHandler();

        $requestFactory = static function (array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null): Request {
            $request = new Request($query, $request, $attributes, $cookies, $files, $server, $content);
            $request->server->set('SERVER_NAME', 'localhost');

            return $request;
        };

        Request::setFactory($requestFactory);

        $backofficeBootstrap = new BackofficeBootstrap();
        $this->client = new HttpKernelBrowser($backofficeBootstrap->boot());
    }

    /**
     * The WhoopsErrorHandler converts E_USER_DEPRECATED into exception, we need to disable it for controller tests.
     */
    protected function disableWhoopsErrorHandler(): void
    {
        $this->getConfigHelper()->setConfig(ErrorHandlerConstants::IS_PRETTY_ERROR_HANDLER_ENABLED, false);
    }
}
