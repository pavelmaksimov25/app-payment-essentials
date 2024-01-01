<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerProjectTest\Zed\Stripe\Communication\Plugin\Payment;

use Codeception\Test\Unit;
use SprykerProject\Zed\Stripe\Communication\Plugin\Payment\StripePlatformPlugin;
use SprykerProjectTest\Zed\Stripe\StripeCommunicationTester;
use SprykerTest\Shared\Testify\Helper\DependencyHelperTrait;

/**
 * Auto-generated group annotations
 *
 * @group SprykerProjectTest
 * @group Zed
 * @group Stripe
 * @group Communication
 * @group Plugin
 * @group Payment
 * @group StripePlatformPluginCapturePaymentTest
 * Add your own group annotations below this line
 */
class StripePlatformPluginCapturePaymentTest extends Unit
{
    use DependencyHelperTrait;

    protected StripeCommunicationTester $tester;

    public function testCapturePaymentReturnsSuccessfulResponseWhenIntentReturnsStatusSucceed(): void
    {
        // Arrange
        $capturePaymentRequestTransfer = $this->tester->haveCapturePaymentRequestTransfer();

        $this->tester->mockPaymentIntentResponse([
            'status' => 'succeeded',
        ], [], 'capture');

        // Act
        $stripePlatformPlugin = new StripePlatformPlugin();
        $stripePlatformPlugin->setFacade($this->tester->getFacade());
        $capturePaymentResponseTransfer = $stripePlatformPlugin->capturePayment($capturePaymentRequestTransfer);

        // Assert
        $this->assertTrue($capturePaymentResponseTransfer->getIsSuccessful(), 'Expected to get a successful response but got a failed one.');
    }

    public function testCapturePaymentReturnsFailedResponseWhenIntentDoesNotReturnStatusSucceed(): void
    {
        // Arrange
        $capturePaymentRequestTransfer = $this->tester->haveCapturePaymentRequestTransfer();

        $this->tester->mockPaymentIntentResponse([
            'status' => 'processing',
        ], [], 'capture');

        // Act
        $stripePlatformPlugin = new StripePlatformPlugin();
        $stripePlatformPlugin->setFacade($this->tester->getFacade());
        $capturePaymentResponseTransfer = $stripePlatformPlugin->capturePayment($capturePaymentRequestTransfer);

        // Assert
        $this->assertFalse($capturePaymentResponseTransfer->getIsSuccessful(), 'Expected to get a failed response but got a successful one.');
    }

    public function testCapturePaymentReturnsFailedResponseWhenIntentThrowsException(): void
    {
        // Arrange
        $capturePaymentRequestTransfer = $this->tester->haveCapturePaymentRequestTransfer();

        $this->tester->mockPaymentIntentThatThrowsAnExceptionOnMethodCall('capture');

        // Act
        $stripePlatformPlugin = new StripePlatformPlugin();
        $stripePlatformPlugin->setFacade($this->tester->getFacade());
        $capturePaymentResponseTransfer = $stripePlatformPlugin->capturePayment($capturePaymentRequestTransfer);

        // Assert
        $this->assertFalse($capturePaymentResponseTransfer->getIsSuccessful(), 'Expected to get a failed response but got a successful one.');
    }
}
