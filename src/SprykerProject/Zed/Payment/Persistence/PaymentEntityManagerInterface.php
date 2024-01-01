<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerProject\Zed\Payment\Persistence;

use Generated\Shared\Transfer\PaymentTransfer;

interface PaymentEntityManagerInterface
{
    public function createPayment(PaymentTransfer $paymentTransfer): PaymentTransfer;

    public function savePayment(PaymentTransfer $paymentTransfer): PaymentTransfer;
}
