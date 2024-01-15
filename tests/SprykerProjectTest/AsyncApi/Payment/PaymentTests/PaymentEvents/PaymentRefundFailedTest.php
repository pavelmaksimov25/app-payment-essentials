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
 * @group PaymentRefundFailedTest
 * Add your own group annotations below this line
 */
class PaymentRefundFailedTest extends Unit
{
    protected PaymentAsyncApiTester $tester;

    public function testPaymentRefundFailedMessageIsSend(): void
    {
        // Arrange
        $paymentRefundFailedTransfer = $this->tester->havePaymentRefundFailedTransfer();

        // Act: Here you call the facade method where you expect that the message will be sent
        (new MessageBrokerFacade())->sendMessage($paymentRefundFailedTransfer);

        // Assert
        $this->tester->assertMessageWasEmittedOnChannel($paymentRefundFailedTransfer, 'payment-events');

        $this->markTestIncomplete('Missing implementation');
    }
}
