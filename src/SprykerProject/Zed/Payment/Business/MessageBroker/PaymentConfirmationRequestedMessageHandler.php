<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace AppPayment\Zed\Payment\Business\MessageBroker;

use Generated\Shared\Transfer\CapturePaymentRequestTransfer;
use Generated\Shared\Transfer\PaymentConfirmationRequestedTransfer;
use AppPayment\Zed\Payment\Business\MessageBroker\TenantIdentifier\TenantIdentifierExtractor;
use AppPayment\Zed\Payment\Business\Payment\Capture\PaymentCapturer;
use AppPayment\Zed\Payment\Persistence\PaymentRepositoryInterface;

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
