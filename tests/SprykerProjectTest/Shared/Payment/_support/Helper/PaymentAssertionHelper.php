<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace AppPaymentTest\Shared\Payment\Helper;

use Codeception\Module;
use Codeception\Util\Shared\Asserts;
use Generated\Shared\Transfer\PaymentTransfer;

class PaymentAssertionHelper extends Module
{
    use Asserts;
    use PaymentHelperTrait;

    public function assertPaymentHasStatus(PaymentTransfer $paymentTransfer, string $expectedStatus): void
    {
        $updatedPaymentTransfer = $this->getPaymentHelper()->getPaymentTransferByTransactionId($paymentTransfer->getTransactionId());
        $this->assertEquals($expectedStatus, $updatedPaymentTransfer->getStatus(), sprintf('Expected payment to have status "%s" but status "%s" was found.', $expectedStatus, $updatedPaymentTransfer->getStatus()));
    }
}
