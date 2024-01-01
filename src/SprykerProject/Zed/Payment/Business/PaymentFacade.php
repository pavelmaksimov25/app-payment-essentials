<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerProject\Zed\Payment\Business;

use Generated\Shared\Transfer\AppConfigTransfer;
use Generated\Shared\Transfer\AppDisconnectTransfer;
use Generated\Shared\Transfer\GlueRequestTransfer;
use Generated\Shared\Transfer\GlueRequestValidationTransfer;
use Generated\Shared\Transfer\InitializePaymentRequestTransfer;
use Generated\Shared\Transfer\InitializePaymentResponseTransfer;
use Generated\Shared\Transfer\PaymentCancelReservationRequestedTransfer;
use Generated\Shared\Transfer\PaymentConfirmationRequestedTransfer;
use Generated\Shared\Transfer\PaymentPageRequestTransfer;
use Generated\Shared\Transfer\PaymentPageResponseTransfer;
use Generated\Shared\Transfer\PaymentRefundRequestedTransfer;
use Generated\Shared\Transfer\WebhookRequestTransfer;
use Generated\Shared\Transfer\WebhookResponseTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \SprykerProject\Zed\Payment\Business\PaymentBusinessFactory getFactory()
 * @method \SprykerProject\Zed\Payment\Persistence\PaymentRepositoryInterface getRepository()
 * @method \SprykerProject\Zed\Payment\Persistence\PaymentEntityManagerInterface getEntityManager()
 */
class PaymentFacade extends AbstractFacade implements PaymentFacadeInterface
{
    /**
     * @inheritDoc
     */
    public function validatePaymentConfiguration(GlueRequestTransfer $glueRequestTransfer): GlueRequestValidationTransfer
    {
        return $this->getFactory()->createPayment()->validateConfiguration($glueRequestTransfer);
    }

    /**
     * @inheritDoc
     */
    public function initializePayment(InitializePaymentRequestTransfer $initializePaymentRequestTransfer): InitializePaymentResponseTransfer
    {
        return $this->getFactory()->createPayment()->initializePayment($initializePaymentRequestTransfer);
    }

    /**
     * @inheritDoc
     */
    public function getPaymentPage(PaymentPageRequestTransfer $paymentPageRequestTransfer): PaymentPageResponseTransfer
    {
        return $this->getFactory()->createPayment()->getPaymentPage($paymentPageRequestTransfer);
    }

    /**
     * @inheritDoc
     */
    public function handleWebhook(WebhookRequestTransfer $webhookRequestTransfer): WebhookResponseTransfer
    {
        return $this->getFactory()->createWebhookHandler()->handleWebhook($webhookRequestTransfer);
    }

    /**
     * @inheritDoc
     */
    public function sendPaymentMethodAddedMessage(AppConfigTransfer $appConfigTransfer): AppConfigTransfer
    {
        return $this->getFactory()->createMessageSender()->sendPaymentMethodAddedMessage($appConfigTransfer);
    }

    /**
     * @inheritDoc
     */
    public function sendPaymentMethodDeletedMessage(AppDisconnectTransfer $appDisconnectTransfer): AppDisconnectTransfer
    {
        return $this->getFactory()->createMessageSender()->sendPaymentMethodDeletedMessage($appDisconnectTransfer);
    }

    /**
     * {@inheritDoc}
     */
    public function handlePaymentCancelReservationRequested(PaymentCancelReservationRequestedTransfer $paymentCancelReservationRequestedTransfer): void
    {
        $this->getFactory()->createPaymentCancelReservationRequestedMessageHandler()->handlePaymentCancelReservationRequested($paymentCancelReservationRequestedTransfer);
    }

    /**
     * {@inheritDoc}
     */
    public function handlePaymentConfirmationRequested(PaymentConfirmationRequestedTransfer $paymentConfirmationRequestedTransfer): void
    {
        $this->getFactory()->createPaymentConfirmationRequestedMessageHandler()->handlePaymentConfirmationRequested($paymentConfirmationRequestedTransfer);
    }

    /**
     * {@inheritDoc}
     */
    public function handlePaymentRefundRequested(PaymentRefundRequestedTransfer $paymentRefundRequestedTransfer): void
    {
        $this->getFactory()->createPaymentRefundRequestedMessageHandler()->handlePaymentRefundRequested($paymentRefundRequestedTransfer);
    }
}
