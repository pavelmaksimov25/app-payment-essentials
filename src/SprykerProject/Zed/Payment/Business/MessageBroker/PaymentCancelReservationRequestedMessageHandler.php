<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace AppPayment\Zed\Payment\Business\MessageBroker;

use Generated\Shared\Transfer\PaymentCancelReservationRequestedTransfer;

class PaymentCancelReservationRequestedMessageHandler implements PaymentCancelReservationRequestedMessageHandlerInterface
{
    public function handlePaymentCancelReservationRequested(
        PaymentCancelReservationRequestedTransfer $paymentCancelReservationRequestedTransfer
    ): void {
        // Handle the message here
    }
}
