<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace AppPayment\Zed\Payment\Persistence\Exception;

use AppPayment\Zed\Payment\Business\Message\MessageBuilder;

class PaymentByTransactionIdNotFoundException extends PaymentException
{
    public function __construct(string $transactionId)
    {
        parent::__construct(MessageBuilder::paymentByTransactionIdNotFound($transactionId));
    }
}
