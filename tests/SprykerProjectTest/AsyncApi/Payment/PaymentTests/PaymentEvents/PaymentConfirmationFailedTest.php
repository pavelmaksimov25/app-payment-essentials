<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerProjectTest\AsyncApi\Payment\PaymentTests\PaymentEvents;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\WebhookRequestTransfer;
use SprykerProject\Zed\Payment\Business\Payment\Status\PaymentStatusEnum;
use SprykerProjectTest\AsyncApi\Payment\PaymentAsyncApiTester;
use Ramsey\Uuid\Uuid;
use SprykerTest\Shared\Testify\Helper\DependencyHelperTrait;

/**
 * Auto-generated group annotations
 *
 * @group SprykerProjectTest
 * @group AsyncApi
 * @group Payment
 * @group PaymentTests
 * @group PaymentEvents
 * @group PaymentConfirmationFailedTest
 * Add your own group annotations below this line
 */
class PaymentConfirmationFailedTest extends Unit
{
    use DependencyHelperTrait;

    protected PaymentAsyncApiTester $tester;

    /**
     * The PaymentConfirmationFailed message is sent when the payment should be confirmed but the PaymentPluginInterface implementation returns a failed response.
     */
    public function testPaymentConfirmationFailedMessageIsSendWhenWebhook(): void
    {
        // Arrange
        $paymentConfirmationFailedTransfer = $this->tester->havePaymentConfirmationFailedTransfer();

        $transactionId = Uuid::uuid4()->toString();
        $tenantIdentifier = Uuid::uuid4()->toString();

        $this->tester->haveAppConfigForTenant($tenantIdentifier);
        $this->tester->havePaymentForTransactionId($transactionId, $tenantIdentifier);

        $webhookRequestTransfer = (new WebhookRequestTransfer())->setContent('{"transactionId":"' . $transactionId . '"}');
        $this->tester->mockPlatformPlugin($transactionId, PaymentStatusEnum::STATUS_CAPTURE_FAILED);

        // Act
        $this->tester->getFacade()->handleWebhook($webhookRequestTransfer);

        // Assert
        $this->tester->assertMessageWasEmittedOnChannel($paymentConfirmationFailedTransfer, 'payment-events');
    }
}
