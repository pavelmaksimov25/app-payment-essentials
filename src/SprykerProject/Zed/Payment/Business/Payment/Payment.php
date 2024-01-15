<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace AppPayment\Zed\Payment\Business\Payment;

use Generated\Shared\Transfer\GlueRequestTransfer;
use Generated\Shared\Transfer\GlueRequestValidationTransfer;
use Generated\Shared\Transfer\InitializePaymentRequestTransfer;
use Generated\Shared\Transfer\InitializePaymentResponseTransfer;
use Generated\Shared\Transfer\PaymentPageRequestTransfer;
use Generated\Shared\Transfer\PaymentPageResponseTransfer;
use AppPayment\Zed\Payment\Business\Payment\Initialize\PaymentInitializer;
use AppPayment\Zed\Payment\Business\Payment\Page\PaymentPage;
use AppPayment\Zed\Payment\Business\Payment\Validate\ConfigurationValidator;
use AppPayment\Zed\Payment\Business\Payment\Webhook\WebhookHandler;
use AppPayment\Zed\Payment\Dependency\Plugin\PlatformPluginInterface;

class Payment
{
    public function __construct(
        protected PlatformPluginInterface $platformPlugin,
        protected ConfigurationValidator $configurationValidator,
        protected PaymentInitializer $paymentInitializer,
        protected PaymentPage $paymentPage,
        protected WebhookHandler $webhookHandler
    ) {
    }

    public function validateConfiguration(GlueRequestTransfer $glueRequestTransfer): GlueRequestValidationTransfer
    {
        return $this->configurationValidator->validatePaymentConfiguration($glueRequestTransfer);
    }

    public function initializePayment(InitializePaymentRequestTransfer $initializePaymentRequestTransfer): InitializePaymentResponseTransfer
    {
        return $this->paymentInitializer->initializePayment($initializePaymentRequestTransfer);
    }

    public function getPaymentPage(PaymentPageRequestTransfer $paymentPageRequestTransfer): PaymentPageResponseTransfer
    {
        return $this->paymentPage->getPaymentPage($paymentPageRequestTransfer);
    }
}
