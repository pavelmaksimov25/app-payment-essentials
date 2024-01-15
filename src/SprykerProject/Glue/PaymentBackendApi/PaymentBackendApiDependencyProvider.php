<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace AppPayment\Glue\PaymentBackendApi;

use AppPayment\Glue\PaymentBackendApi\Plugin\PaymentBackendApi\GlueRequestWebhookMapperPluginInterface;
use Spryker\Glue\Kernel\Backend\AbstractBundleDependencyProvider;
use Spryker\Glue\Kernel\Backend\Container;

class PaymentBackendApiDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const FACADE_PAYMENT = 'PAYMENT_BACKEND_API:FACADE_PAYMENT';

    /**
     * @var string
     */
    public const PLUGIN_GLUE_REQUEST_WEBHOOK_MAPPER = 'PAYMENT_BACKEND_API:PLUGIN_GLUE_REQUEST_WEBHOOK_MAPPER';

    public function provideBackendDependencies(Container $container): Container
    {
        $container = parent::provideBackendDependencies($container);
        $container = $this->addPaymentFacade($container);
        $container = $this->addGlueRequestWebhookMapperPlugin($container);

        return $container;
    }

    protected function addPaymentFacade(Container $container): Container
    {
        $container->set(static::FACADE_PAYMENT, static function (Container $container) {
            // The PaymentFacade will always be mocked
            // @codeCoverageIgnoreStart
            return $container->getLocator()->payment()->facade();
            // @codeCoverageIgnoreEnd
        });

        return $container;
    }

    protected function addGlueRequestWebhookMapperPlugin(Container $container): Container
    {
        $container->set(static::PLUGIN_GLUE_REQUEST_WEBHOOK_MAPPER, function (): ?GlueRequestWebhookMapperPluginInterface {
            return $this->getGlueRequestWebhookMapperPlugin();
        });

        return $container;
    }

    protected function getGlueRequestWebhookMapperPlugin(): ?GlueRequestWebhookMapperPluginInterface
    {
        return null;
    }
}
