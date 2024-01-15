<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace AppPaymentTest\AsyncApi\Payment\PaymentTests\PaymentCommands;

use Codeception\Test\Unit;
use AppPaymentTest\AsyncApi\Payment\PaymentAsyncApiTester;

/**
 * Auto-generated group annotations
 *
 * @group AppPaymentTest
 * @group AsyncApi
 * @group Payment
 * @group PaymentTests
 * @group PaymentCommands
 * @group PaymentRefundRequestedTest
 * Add your own group annotations below this line
 */
class PaymentRefundRequestedTest extends Unit
{
    protected PaymentAsyncApiTester $tester;

    public function testPaymentRefundRequestedMessageIsHandled(): void
    {
        // Arrange
        $paymentRefundRequestedTransfer = $this->tester->havePaymentRefundRequestedTransfer();

        // Act: This will trigger the MessageHandlerPlugin for this message.
        $this->tester->runMessageReceiveTest($paymentRefundRequestedTransfer, 'payment-commands');

        // Assert
        // You need to update the assertion to something meaningful. e.g. test if an entity was saved to the database.
        $this->assertTrue(true);

        $this->markTestIncomplete('Missing implementation');
    }
}
