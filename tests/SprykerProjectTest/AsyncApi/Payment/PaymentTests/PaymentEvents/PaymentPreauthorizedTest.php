<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerProjectTest\AsyncApi\Payment\PaymentTests\PaymentEvents;

use Codeception\Stub;
use Codeception\Test\Unit;
use Generated\Shared\Transfer\WebhookRequestTransfer;
use Generated\Shared\Transfer\WebhookResponseTransfer;
use SprykerProject\Zed\Payment\Business\Payment\Status\PaymentStatusEnum;
use SprykerProject\Zed\Payment\Dependency\Plugin\PlatformPluginInterface;
use SprykerProject\Zed\Payment\PaymentDependencyProvider;
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
 * @group PaymentPreauthorizedTest
 * Add your own group annotations below this line
 */
class PaymentPreauthorizedTest extends Unit
{
    use DependencyHelperTrait;

    protected PaymentAsyncApiTester $tester;

    /**
     * The PaymentPreauthorized message is sent when the Webhook handler receives a successful response from the PaymentPlatformPlugin and the status of the Payment is changed to PaymentStatusEnum::STATUS_AUTHORIZED.
     */
    public function testPaymentPreauthorizedMessageIsSend(): void
    {
        // Arrange
        $transactionId = Uuid::uuid4()->toString();
        $tenantIdentifier = Uuid::uuid4()->toString();

        $this->tester->haveAppConfigForTenant($tenantIdentifier);
        $this->tester->havePaymentForTransactionId($transactionId, $tenantIdentifier);

        $paymentPreauthorizedTransfer = $this->tester->havePaymentPreauthorizedTransfer();

        $webHookRequestTransfer = new WebhookRequestTransfer();
        $webHookRequestTransfer->setTransactionId($transactionId);

        $platformPluginMock = Stub::makeEmpty(PlatformPluginInterface::class, [
            'handleWebhook' => function (WebhookRequestTransfer $webhookRequestTransfer) use ($transactionId): WebhookResponseTransfer {
                // Ensure that required data is passed to the PaymentPlatformPlugin
                $this->assertNotNull($webhookRequestTransfer->getPayment());
                $this->assertNotNull($webhookRequestTransfer->getAppConfig());
                $this->assertSame($webhookRequestTransfer->getTransactionId(), $transactionId);

                $webhookResponseTransfer = new WebhookResponseTransfer();
                $webhookResponseTransfer->setIsSuccessful(true);
                $webhookResponseTransfer->setPaymentStatus(PaymentStatusEnum::STATUS_AUTHORIZED);

                return $webhookResponseTransfer;
            },
        ]);

        $this->getDependencyHelper()->setDependency(PaymentDependencyProvider::PLUGIN_PLATFORM, $platformPluginMock);

        // Act
        $this->tester->getFacade()->handleWebhook($webHookRequestTransfer);

        // Assert
        $this->tester->assertMessageWasEmittedOnChannel($paymentPreauthorizedTransfer, 'payment-events');
    }
}
