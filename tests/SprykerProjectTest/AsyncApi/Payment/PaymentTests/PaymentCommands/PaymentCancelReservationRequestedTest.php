<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerProjectTest\AsyncApi\Payment\PaymentTests\PaymentCommands;

use Codeception\Test\Unit;
use SprykerProjectTest\AsyncApi\Payment\PaymentAsyncApiTester;

/**
 * Auto-generated group annotations
 *
 * @group SprykerProjectTest
 * @group AsyncApi
 * @group Payment
 * @group PaymentTests
 * @group PaymentCommands
 * @group PaymentCancelReservationRequestedTest
 * Add your own group annotations below this line
 */
class PaymentCancelReservationRequestedTest extends Unit
{
    protected PaymentAsyncApiTester $tester;

    public function testPaymentCancelReservationRequestedMessageIsHandled(): void
    {
        // Arrange
        $paymentCancelReservationRequestedTransfer = $this->tester->havePaymentCancelReservationRequestedTransfer();

        // Act: This will trigger the MessageHandlerPlugin for this message.
        $this->tester->runMessageReceiveTest($paymentCancelReservationRequestedTransfer, 'payment-commands');

        // Assert
        // You need to update the assertion to something meaningful. e.g. test if an entity was saved to the database.
        $this->assertTrue(true);

        $this->markTestIncomplete('Missing implementation');
    }
}
