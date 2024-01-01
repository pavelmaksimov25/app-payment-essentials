<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerProjectTest\Zed\Stripe\Communication\Plugin\Payment;

use Codeception\Test\Unit;
use SprykerProject\Zed\Payment\Business\Payment\Status\PaymentStatusEnum;
use SprykerProject\Zed\Stripe\Communication\Plugin\Payment\StripePlatformPlugin;
use SprykerProjectTest\Zed\Stripe\StripeCommunicationTester;
use Spryker\Shared\Kernel\Transfer\Exception\NullValueException;
use Stripe\Exception\SignatureVerificationException;

/**
 * Auto-generated group annotations
 *
 * @group SprykerProjectTest
 * @group Zed
 * @group Stripe
 * @group Communication
 * @group Plugin
 * @group Payment
 * @group StripePlatformPluginHandleWebhookTest
 * Add your own group annotations below this line
 */
class StripePlatformPluginHandleWebhookTest extends Unit
{
    protected StripeCommunicationTester $tester;

    public function testHandleWebhookReturnsSuccessfulResponseWhenPayloadHasAmountCapturableUpdatedAndStatusRequiresCapture(): void
    {
        // Arrange
        $webhookRequestTransfer = $this->tester->getWebhookRequestTransfer('valid-webhook-payload-amount_capturable_updated');

        // Act
        $stripePlatformPlugin = new StripePlatformPlugin();
        $webhookResponseTransfer = $stripePlatformPlugin->handleWebhook($webhookRequestTransfer);

        // Assert
        $this->assertTrue($webhookResponseTransfer->getIsSuccessful(), 'Expected to get a successful response but got a failed one.');
    }

    public function testPaymentStatusIsChangedToAuthorizedWhenWebhookDataObjectStatusIsRequiresCapture(): void
    {
        // Arrange
        $webhookRequestTransfer = $this->tester->getWebhookRequestTransfer('valid-webhook-payload-amount_capturable_updated');

        // Act
        $stripePlatformPlugin = new StripePlatformPlugin();
        $webhookResponseTransfer = $stripePlatformPlugin->handleWebhook($webhookRequestTransfer);

        // Assert
        $this->assertSame($webhookResponseTransfer->getPaymentStatus(), PaymentStatusEnum::STATUS_AUTHORIZED, sprintf('Expected to get a "%s" status but got a "%s" one.', PaymentStatusEnum::STATUS_AUTHORIZED, $webhookResponseTransfer->getPaymentStatus()));
    }

    public function testHandleWebhookReturnsSuccessfulResponseWhenPayloadHasPaymentSucceeded(): void
    {
        // Arrange
        $webhookRequestTransfer = $this->tester->getWebhookRequestTransfer('valid-webhook-payload-succeeded');

        // Act
        $stripePlatformPlugin = new StripePlatformPlugin();
        $webhookResponseTransfer = $stripePlatformPlugin->handleWebhook($webhookRequestTransfer);

        // Assert
        $this->assertTrue($webhookResponseTransfer->getIsSuccessful(), 'Expected to get a successful response but got a failed one.');
    }

    public function testHandleWebhookReturnsSuccessfulResponseWhenPayloadHasPaymentFailed(): void
    {
        // Arrange
        $webhookRequestTransfer = $this->tester->getWebhookRequestTransfer('valid-webhook-payload-payment_failed');

        // Act
        $stripePlatformPlugin = new StripePlatformPlugin();
        $webhookResponseTransfer = $stripePlatformPlugin->handleWebhook($webhookRequestTransfer);

        // Assert
        $this->assertTrue($webhookResponseTransfer->getIsSuccessful(), 'Expected to get a successful response but got a failed one.');
    }

    public function testHandleWebhookReturnsFailedResponseWhenPayloadHasInvalidType(): void
    {
        // Arrange
        $webhookRequestTransfer = $this->tester->getWebhookRequestTransfer('invalid_type-webhook-payload');

        // Act
        $stripePlatformPlugin = new StripePlatformPlugin();
        $webhookResponseTransfer = $stripePlatformPlugin->handleWebhook($webhookRequestTransfer);

        // Assert
        $this->assertFalse($webhookResponseTransfer->getIsSuccessful(), 'Expected to get a failed response but got a successful one.');
    }

    public function testHandleWebhookReturnsFailedResponseWhenPayloadHasInvalidEvent(): void
    {
        // Arrange
        $webhookRequestTransfer = $this->tester->getWebhookRequestTransfer('invalid_event-webhook-payload');

        // Act
        $stripePlatformPlugin = new StripePlatformPlugin();
        $webhookResponseTransfer = $stripePlatformPlugin->handleWebhook($webhookRequestTransfer);

        // Assert
        $this->assertFalse($webhookResponseTransfer->getIsSuccessful(), 'Expected to get a failed response but got a successful one.');
    }

    public function testHandleWebhookThrowsExceptionWhenWebhookRequestDoesNotHaveSignatureHeader(): void
    {
        // Arrange
        $webhookRequestTransfer = $this->tester->getWebhookRequestTransfer('valid-webhook-payload-succeeded');
        $webhookRequestTransfer->setSignatureHeader(null);

        // Expect
        $this->expectException(NullValueException::class);

        // Act
        $stripePlatformPlugin = new StripePlatformPlugin();
        $stripePlatformPlugin->handleWebhook($webhookRequestTransfer);
    }

    public function testHandleWebhookThrowsExceptionWhenWebhookRequestHasInvalidSignatureHeader(): void
    {
        // Arrange
        $webhookRequestTransfer = $this->tester->getWebhookRequestTransfer('valid-webhook-payload-succeeded');
        $webhookRequestTransfer->setSignatureHeader('invalid-signature-header');

        // Expect
        $this->expectException(SignatureVerificationException::class);

        // Act
        $stripePlatformPlugin = new StripePlatformPlugin();
        $stripePlatformPlugin->handleWebhook($webhookRequestTransfer);
    }
}
