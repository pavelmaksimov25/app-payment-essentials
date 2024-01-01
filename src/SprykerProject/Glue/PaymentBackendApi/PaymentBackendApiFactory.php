<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerProject\Glue\PaymentBackendApi;

use SprykerProject\Glue\PaymentBackendApi\Mapper\Payment\GlueRequestPaymentMapper;
use SprykerProject\Glue\PaymentBackendApi\Mapper\Payment\GlueRequestPaymentMapperInterface;
use SprykerProject\Glue\PaymentBackendApi\Mapper\Payment\GlueResponsePaymentMapper;
use SprykerProject\Glue\PaymentBackendApi\Mapper\Payment\GlueResponsePaymentMapperInterface;
use SprykerProject\Glue\PaymentBackendApi\Mapper\Webhook\GlueRequestWebhookMapper;
use SprykerProject\Glue\PaymentBackendApi\Mapper\Webhook\GlueRequestWebhookMapperInterface;
use SprykerProject\Glue\PaymentBackendApi\Mapper\Webhook\GlueResponseWebhookMapper;
use SprykerProject\Glue\PaymentBackendApi\Mapper\Webhook\GlueResponseWebhookMapperInterface;
use SprykerProject\Glue\PaymentBackendApi\Plugin\PaymentBackendApi\GlueRequestWebhookMapperPluginInterface;
use SprykerProject\Zed\Payment\Business\PaymentFacadeInterface;
use Spryker\Glue\Kernel\Backend\AbstractFactory;

class PaymentBackendApiFactory extends AbstractFactory
{
    public function createGlueRequestPaymentMapper(): GlueRequestPaymentMapperInterface
    {
        return new GlueRequestPaymentMapper();
    }

    public function createGlueResponsePaymentMapper(): GlueResponsePaymentMapperInterface
    {
        return new GlueResponsePaymentMapper();
    }

    public function createGlueRequestWebhookMapper(): GlueRequestWebhookMapperInterface
    {
        return new GlueRequestWebhookMapper($this->getGlueRequestWebhookMapperPlugin());
    }

    public function createGlueResponseWebhookMapper(): GlueResponseWebhookMapperInterface
    {
        return new GlueResponseWebhookMapper();
    }

    public function getGlueRequestWebhookMapperPlugin(): ?GlueRequestWebhookMapperPluginInterface
    {
        /** @phpstan-var \SprykerProject\Glue\PaymentBackendApi\Plugin\PaymentBackendApi\GlueRequestWebhookMapperPluginInterface|null */
        return $this->getProvidedDependency(PaymentBackendApiDependencyProvider::PLUGIN_GLUE_REQUEST_WEBHOOK_MAPPER);
    }

    public function getPaymentFacade(): PaymentFacadeInterface
    {
        /** @phpstan-var \SprykerProject\Zed\Payment\Business\PaymentFacadeInterface */
        return $this->getProvidedDependency(PaymentBackendApiDependencyProvider::FACADE_PAYMENT);
    }
}
