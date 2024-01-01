<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerProjectTest\AsyncApi\Payment\PaymentTests\PaymentEvents;

use Codeception\Test\Unit;
use SprykerProjectTest\AsyncApi\Payment\PaymentAsyncApiTester;
use Spryker\Zed\MessageBroker\Business\MessageBrokerFacade;

/**
 * Auto-generated group annotations
 *
 * @group SprykerProjectTest
 * @group AsyncApi
 * @group Payment
 * @group PaymentTests
 * @group PaymentEvents
 * @group PaymentReservationCanceledTest
 * Add your own group annotations below this line
 */
class PaymentReservationCanceledTest extends Unit
{
    protected PaymentAsyncApiTester $tester;

    public function testPaymentReservationCanceledMessageIsSend(): void
    {
        // Arrange
        $paymentReservationCanceledTransfer = $this->tester->havePaymentReservationCanceledTransfer();

        // Act: Here you call the facade method where you expect that the message will be sent
        (new MessageBrokerFacade())->sendMessage($paymentReservationCanceledTransfer);

        // Assert
        $this->tester->assertMessageWasEmittedOnChannel($paymentReservationCanceledTransfer, 'payment-events');

        $this->markTestIncomplete('Missing implementation');
    }
}
