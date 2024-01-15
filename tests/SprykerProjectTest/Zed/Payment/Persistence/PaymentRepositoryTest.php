<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace AppPaymentTest\Zed\Payment\Persistence;

use Codeception\Test\Unit;
use Exception;
use SprykerProject\Zed\Payment\Business\Message\MessageBuilder;
use SprykerProject\Zed\Payment\Persistence\PaymentRepository;
use Ramsey\Uuid\Uuid;

/**
 * Auto-generated group annotations
 *
 * @group AppPaymentTest
 * @group Zed
 * @group Payment
 * @group Persistence
 * @group PaymentRepositoryTest
 * Add your own group annotations below this line
 */
class PaymentRepositoryTest extends Unit
{
    public function testGetByTransactionIdThrowsAnExceptionWhenNoPaymentForTransactionIdFound(): void
    {
        // Arrange
        $paymentRepository = new PaymentRepository();
        $transactionId = Uuid::uuid4()->toString();

        // Expect
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(MessageBuilder::paymentByTransactionIdNotFound($transactionId));

        // Act
        $paymentRepository->getByTransactionId($transactionId);
    }
}
