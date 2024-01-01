<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerProject\Zed\Payment\Business\MessageBroker;

use Generated\Shared\Transfer\CapturePaymentRequestTransfer;
use Generated\Shared\Transfer\PaymentConfirmationRequestedTransfer;
use SprykerProject\Zed\Payment\Business\MessageBroker\TenantIdentifier\TenantIdentifierExtractor;
use SprykerProject\Zed\Payment\Business\Payment\Capture\PaymentCapturer;
use SprykerProject\Zed\Payment\Persistence\PaymentRepositoryInterface;

class PaymentConfirmationRequestedMessageHandler implements PaymentConfirmationRequestedMessageHandlerInterface
{
    public function __construct(
        protected PaymentRepositoryInterface $paymentRepository,
        protected TenantIdentifierExtractor $tenantIdentifierExtractor,
        protected PaymentCapturer $paymentCapturer
    ) {
    }

    public function handlePaymentConfirmationRequested(
        PaymentConfirmationRequestedTransfer $paymentConfirmationRequestedTransfer
    ): void {
        $tenantIdentifier = $this->tenantIdentifierExtractor->getTenantIdentifierFromMessage($paymentConfirmationRequestedTransfer);

        $paymentTransfer = $this->paymentRepository->getByTenantIdentifierAndOrderReference(
            $tenantIdentifier,
            $paymentConfirmationRequestedTransfer->getOrderReferenceOrFail(),
        );

        $capturePaymentRequestTransfer = (new CapturePaymentRequestTransfer())
            ->setTransactionId($paymentTransfer->getTransactionIdOrFail())
            ->setPayment($paymentTransfer);

        $this->paymentCapturer->capturePayment($capturePaymentRequestTransfer);
    }
}
