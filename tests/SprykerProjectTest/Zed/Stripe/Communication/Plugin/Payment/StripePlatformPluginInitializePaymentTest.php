<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerProjectTest\Zed\Stripe\Communication\Plugin\Payment;

use Codeception\Test\Unit;
use SprykerProject\Zed\Stripe\Communication\Plugin\Payment\StripePlatformPlugin;
use SprykerProjectTest\Zed\Stripe\StripeCommunicationTester;
use Ramsey\Uuid\Uuid;

/**
 * Auto-generated group annotations
 *
 * @group SprykerProjectTest
 * @group Zed
 * @group Stripe
 * @group Communication
 * @group Plugin
 * @group Payment
 * @group StripePlatformPluginInitializePaymentTest
 * Add your own group annotations below this line
 */
class StripePlatformPluginInitializePaymentTest extends Unit
{
    protected StripeCommunicationTester $tester;

    public function testInitializePaymentReturnsSuccessfulResponse(): void
    {
        // Arrange
        $transactionId = Uuid::uuid4()->toString();
        $tenantIdentifier = Uuid::uuid4()->toString();

        $initializePaymentRequestTransfer = $this->tester->haveInitializePaymentRequestWithAppConfigTransfer();

        $this->tester->mockPaymentIntentResponse([], [
            'id' => $transactionId,
        ], 'create', $transactionId);

        // Act
        $stripePlatformPlugin = new StripePlatformPlugin();
        $stripePlatformPlugin->setFacade($this->tester->getFacade());

        $initializePaymentResponseTransfer = $stripePlatformPlugin->initializePayment($initializePaymentRequestTransfer);

        // Assert
        $this->assertTrue($initializePaymentResponseTransfer->getIsSuccessful(), 'Expected to get a successful response but got a failed one.');
    }

    public function testInitializePaymentReturnsFailedResponseWhenIntentDoesNotReturnId(): void
    {
        // Arrange
        $transactionId = Uuid::uuid4()->toString();
        $initializePaymentRequestTransfer = $this->tester->haveInitializePaymentRequestWithAppConfigTransfer();

        $this->tester->mockPaymentIntentResponse([], ['id' => null], 'create', $transactionId);

        // Act
        $stripePlatformPlugin = new StripePlatformPlugin();
        $stripePlatformPlugin->setFacade($this->tester->getFacade());

        $initializePaymentResponseTransfer = $stripePlatformPlugin->initializePayment($initializePaymentRequestTransfer);

        // Assert
        $this->assertFalse($initializePaymentResponseTransfer->getIsSuccessful(), 'Expected to get a failed response but got a successful one.');
    }

    public function testInitializePaymentReturnsFailedResponseWhenStripeIntentsCreateThrowsAnException(): void
    {
        // Arrange
        $initializePaymentRequestTransfer = $this->tester->haveInitializePaymentRequestWithAppConfigTransfer();

        $this->tester->mockPaymentIntentThatThrowsAnExceptionOnMethodCall('create');

        // Act
        $stripePlatformPlugin = new StripePlatformPlugin();
        $stripePlatformPlugin->setFacade($this->tester->getFacade());

        $initializePaymentResponseTransfer = $stripePlatformPlugin->initializePayment($initializePaymentRequestTransfer);

        // Assert
        $this->assertFalse($initializePaymentResponseTransfer->getIsSuccessful(), 'Expected to get a failed response but got a successful one.');
    }
}
