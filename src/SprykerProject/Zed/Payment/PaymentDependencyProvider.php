<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace AppPayment\Zed\Payment;

use AppPayment\Zed\Payment\Dependency\Plugin\PlatformPluginInterface;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

/**
 * @method \AppPayment\Zed\Payment\PaymentConfig getConfig()
 */
class PaymentDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const PLUGIN_PLATFORM = 'PAYMENT:PLUGIN_PLATFORM';

    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);

        return $this->addPlatformPlugin($container);
    }

    protected function addPlatformPlugin(Container $container): Container
    {
        $container->set(static::PLUGIN_PLATFORM, function (): PlatformPluginInterface {
            // @codeCoverageIgnoreStart
            return $this->getPlatformPlugin();
            // @codeCoverageIgnoreEnd
        });

        return $container;
    }

    /**
     * @codeCoverageIgnore
     */
    private function getPlatformPlugin(): PlatformPluginInterface
    {
        throw new \Exception('You need to implement a PlatformPluginInterface');
    }
}
