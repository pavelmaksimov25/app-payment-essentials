<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace AppPayment\Glue\GlueBackendApiApplication;

use AppCore\Glue\GlueBackendApiApplication\GlueBackendApiApplicationDependencyProvider as AppCoreGlueBackendApiApplicationDependencyProvider;
use AppPayment\Glue\PaymentBackendApi\Plugin\GlueApplication\PaymentBackendApiRouteProviderPlugin;
use Spryker\Glue\AppKernel\Plugin\RouteProvider\AppRouteProviderPlugin;
use Spryker\Glue\Kernel\Backend\Container;

class GlueBackendApiApplicationDependencyProvider extends AppCoreGlueBackendApiApplicationDependencyProvider
{
    /**
     * @param Container $container
     * @return Container
     */
    public function provideBackendDependencies(Container $container): Container
    {
        $container = parent::provideBackendDependencies($container);

        return $container;
    }

    /**
     * @return array<\Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\RouteProviderPluginInterface>
     */
    protected function getRouteProviderPlugins(): array
    {
        return [
            new AppRouteProviderPlugin(),
            new PaymentBackendApiRouteProviderPlugin(),
        ];
    }
}
