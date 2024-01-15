<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace AppPayment\Glue\PaymentBackendApi;

use AppPayment\Glue\PaymentBackendApi\Mapper\Payment\GlueRequestPaymentMapper;
use AppPayment\Glue\PaymentBackendApi\Mapper\Payment\GlueRequestPaymentMapperInterface;
use AppPayment\Glue\PaymentBackendApi\Mapper\Payment\GlueResponsePaymentMapper;
use AppPayment\Glue\PaymentBackendApi\Mapper\Payment\GlueResponsePaymentMapperInterface;
use AppPayment\Glue\PaymentBackendApi\Mapper\Webhook\GlueRequestWebhookMapper;
use AppPayment\Glue\PaymentBackendApi\Mapper\Webhook\GlueRequestWebhookMapperInterface;
use AppPayment\Glue\PaymentBackendApi\Mapper\Webhook\GlueResponseWebhookMapper;
use AppPayment\Glue\PaymentBackendApi\Mapper\Webhook\GlueResponseWebhookMapperInterface;
use AppPayment\Glue\PaymentBackendApi\Plugin\PaymentBackendApi\GlueRequestWebhookMapperPluginInterface;
use AppPayment\Zed\Payment\Business\PaymentFacadeInterface;
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
        /** @phpstan-var \AppPayment\Glue\PaymentBackendApi\Plugin\PaymentBackendApi\GlueRequestWebhookMapperPluginInterface|null */
        return $this->getProvidedDependency(PaymentBackendApiDependencyProvider::PLUGIN_GLUE_REQUEST_WEBHOOK_MAPPER);
    }

    public function getPaymentFacade(): PaymentFacadeInterface
    {
        /** @phpstan-var \AppPayment\Zed\Payment\Business\PaymentFacadeInterface */
        return $this->getProvidedDependency(PaymentBackendApiDependencyProvider::FACADE_PAYMENT);
    }
}
