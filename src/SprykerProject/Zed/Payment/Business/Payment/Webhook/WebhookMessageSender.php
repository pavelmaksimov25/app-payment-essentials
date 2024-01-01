<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerProject\Zed\Payment\Business\Payment\Webhook;

use Generated\Shared\Transfer\WebhookRequestTransfer;
use SprykerProject\Zed\Payment\Business\Payment\Message\MessageSender;
use SprykerProject\Zed\Payment\Business\Payment\Status\PaymentStatusEnum;
use Spryker\Shared\Log\LoggerTrait;

class WebhookMessageSender
{
    use LoggerTrait;

    public function __construct(protected MessageSender $messageSender)
    {
    }

    public function determineAndSendMessage(WebhookRequestTransfer $webhookRequestTransfer): void
    {
        $paymentTransfer = $webhookRequestTransfer->getPaymentOrFail();
        $paymentStatus = $paymentTransfer->getStatusOrFail();

        match ($paymentStatus) {
            PaymentStatusEnum::STATUS_CAPTURED => $this->messageSender->sendPaymentConfirmedMessage($paymentTransfer),
            PaymentStatusEnum::STATUS_CAPTURE_FAILED => $this->messageSender->sendPaymentConfirmationFailedMessage($paymentTransfer),
            PaymentStatusEnum::STATUS_AUTHORIZED => $this->messageSender->sendPaymentPreauthorizedMessage($paymentTransfer),
            default => $this->getLogger()->warning(sprintf('Unhandled payment status "%s" for orderReference "%s" and tenantIdentifier "%s".', $paymentStatus, $paymentTransfer->getOrderReferenceOrFail(), $paymentTransfer->getTenantIdentifierOrFail()))
        };
    }
}
