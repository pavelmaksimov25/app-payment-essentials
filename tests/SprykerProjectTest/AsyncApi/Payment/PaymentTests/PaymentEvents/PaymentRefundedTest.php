<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace AppPaymentTest\AsyncApi\Payment\PaymentTests\PaymentEvents;

use Codeception\Test\Unit;
use AppPaymentTest\AsyncApi\Payment\PaymentAsyncApiTester;
use Spryker\Zed\MessageBroker\Business\MessageBrokerFacade;

/**
 * Auto-generated group annotations
 *
 * @group AppPaymentTest
 * @group AsyncApi
 * @group Payment
 * @group PaymentTests
 * @group PaymentEvents
 * @group PaymentRefundedTest
 * Add your own group annotations below this line
 */
class PaymentRefundedTest extends Unit
{
    protected PaymentAsyncApiTester $tester;

    public function testPaymentRefundedMessageIsSend(): void
    {
        // Arrange
        $paymentRefundedTransfer = $this->tester->havePaymentRefundedTransfer();

        // Act: Here you call the facade method where you expect that the message will be sent
        (new MessageBrokerFacade())->sendMessage($paymentRefundedTransfer);

        // Assert
        $this->tester->assertMessageWasEmittedOnChannel($paymentRefundedTransfer, 'payment-events');

        $this->markTestIncomplete('Missing implementation');
    }
}
