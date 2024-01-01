<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerProject\Zed\Payment\Persistence\Propel\Payment\Mapper;

use Generated\Shared\Transfer\PaymentTransfer;
use Orm\Zed\Payment\Persistence\SpyPayment;

class PaymentMapper
{
    public function mapPaymentTransferToPaymentEntity(PaymentTransfer $paymentTransfer, SpyPayment $spyPayment): SpyPayment
    {
        $quoteTransfer = $paymentTransfer->getQuoteOrFail();
        $quoteJson = json_encode($quoteTransfer->toArray());

        $paymentData = $paymentTransfer->modifiedToArray();
        $paymentData[PaymentTransfer::QUOTE] = $quoteJson;

        return $spyPayment->fromArray($paymentData);
    }

    public function mapPaymentEntityToPaymentTransfer(SpyPayment $spyPayment, PaymentTransfer $paymentTransfer): PaymentTransfer
    {
        $quoteData = json_decode((string)$spyPayment->getQuote(), true);

        $paymentData = $spyPayment->toArray();
        $paymentData[PaymentTransfer::QUOTE] = $quoteData;

        return $paymentTransfer->fromArray($paymentData, true);
    }
}
