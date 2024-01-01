<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerProjectTest\AsyncApi\Payment\Helper;

use Codeception\Module;
use Generated\Shared\DataBuilder\PaymentCancelReservationRequestedBuilder;
use Generated\Shared\DataBuilder\PaymentConfirmationFailedBuilder;
use Generated\Shared\DataBuilder\PaymentConfirmationRequestedBuilder;
use Generated\Shared\DataBuilder\PaymentConfirmedBuilder;
use Generated\Shared\DataBuilder\PaymentMethodAddedBuilder;
use Generated\Shared\DataBuilder\PaymentMethodDeletedBuilder;
use Generated\Shared\DataBuilder\PaymentPreauthorizedBuilder;
use Generated\Shared\DataBuilder\PaymentRefundedBuilder;
use Generated\Shared\DataBuilder\PaymentRefundFailedBuilder;
use Generated\Shared\DataBuilder\PaymentRefundRequestedBuilder;
use Generated\Shared\DataBuilder\PaymentReservationCanceledBuilder;
use Generated\Shared\Transfer\PaymentCancelReservationRequestedTransfer;
use Generated\Shared\Transfer\PaymentConfirmationFailedTransfer;
use Generated\Shared\Transfer\PaymentConfirmationRequestedTransfer;
use Generated\Shared\Transfer\PaymentConfirmedTransfer;
use Generated\Shared\Transfer\PaymentMethodAddedTransfer;
use Generated\Shared\Transfer\PaymentMethodDeletedTransfer;
use Generated\Shared\Transfer\PaymentPreauthorizedTransfer;
use Generated\Shared\Transfer\PaymentRefundedTransfer;
use Generated\Shared\Transfer\PaymentRefundFailedTransfer;
use Generated\Shared\Transfer\PaymentRefundRequestedTransfer;
use Generated\Shared\Transfer\PaymentReservationCanceledTransfer;

class PaymentHelper extends Module
{
    public function havePaymentCancelReservationRequestedTransfer(array $seed = []): PaymentCancelReservationRequestedTransfer
    {
        return (new PaymentCancelReservationRequestedBuilder($seed))->build();
    }

    public function havePaymentConfirmationRequestedTransfer(array $seed = []): PaymentConfirmationRequestedTransfer
    {
        return (new PaymentConfirmationRequestedBuilder($seed))->withMessageAttributes()->build();
    }

    public function havePaymentRefundRequestedTransfer(array $seed = []): PaymentRefundRequestedTransfer
    {
        return (new PaymentRefundRequestedBuilder($seed))->build();
    }

    public function havePaymentPreauthorizedTransfer(array $seed = []): PaymentPreauthorizedTransfer
    {
        return (new PaymentPreauthorizedBuilder($seed))->build();
    }

    public function havePaymentConfirmedTransfer(array $seed = []): PaymentConfirmedTransfer
    {
        return (new PaymentConfirmedBuilder($seed))->build();
    }

    public function havePaymentConfirmationFailedTransfer(array $seed = []): PaymentConfirmationFailedTransfer
    {
        return (new PaymentConfirmationFailedBuilder($seed))->build();
    }

    public function havePaymentRefundedTransfer(array $seed = []): PaymentRefundedTransfer
    {
        return (new PaymentRefundedBuilder($seed))->build();
    }

    public function havePaymentRefundFailedTransfer(array $seed = []): PaymentRefundFailedTransfer
    {
        return (new PaymentRefundFailedBuilder($seed))->build();
    }

    public function havePaymentReservationCanceledTransfer(array $seed = []): PaymentReservationCanceledTransfer
    {
        return (new PaymentReservationCanceledBuilder($seed))->build();
    }

    public function havePaymentMethodAddedTransfer(array $seed = []): PaymentMethodAddedTransfer
    {
        return (new PaymentMethodAddedBuilder($seed))->build();
    }

    public function havePaymentMethodDeletedTransfer(array $seed = []): PaymentMethodDeletedTransfer
    {
        return (new PaymentMethodDeletedBuilder($seed))->build();
    }
}
