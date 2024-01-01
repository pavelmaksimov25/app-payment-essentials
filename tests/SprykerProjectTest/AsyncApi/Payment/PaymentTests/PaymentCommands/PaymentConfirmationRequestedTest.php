<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerProjectTest\AsyncApi\Payment\PaymentTests\PaymentCommands;

use Codeception\Stub;
use Codeception\Test\Unit;
use Exception;
use Generated\Shared\Transfer\AppConfigTransfer;
use Generated\Shared\Transfer\CapturePaymentRequestTransfer;
use Generated\Shared\Transfer\CapturePaymentResponseTransfer;
use Generated\Shared\Transfer\PaymentTransfer;
use SprykerProject\Zed\Payment\Business\Payment\Status\PaymentStatusEnum;
use SprykerProject\Zed\Payment\Dependency\Plugin\PlatformPluginInterface;
use SprykerProject\Zed\Payment\PaymentDependencyProvider;
use SprykerProject\Zed\Payment\Persistence\Exception\PaymentByTenantIdentifierAndOrderReferenceNotFoundException;
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
 * @group PaymentCommands
 * @group PaymentConfirmationRequestedTest
 * Add your own group annotations below this line
 */
class PaymentConfirmationRequestedTest extends Unit
{
    use DependencyHelperTrait;

    protected PaymentAsyncApiTester $tester;

    public function testHandlePaymentConfirmationRequestedMessageUpdatesPaymentToCapturedRequested(): void
    {
        // Arrange
        $tenantIdentifier = Uuid::uuid4()->toString();
        $transactionId = Uuid::uuid4()->toString();
        $this->tester->haveAppConfigForTenant($tenantIdentifier);
        $paymentTransfer = $this->tester->havePaymentForTransactionId($transactionId, $tenantIdentifier);

        $paymentConfirmationRequestedTransfer = $this->tester->havePaymentConfirmationRequestedTransfer(['tenantIdentifier' => $tenantIdentifier, 'orderReference' => $paymentTransfer->getOrderReference()]);

        $capturePaymentResponseTransfer = (new CapturePaymentResponseTransfer())
            ->setIsSuccessful(true)
            ->setTransactionId($transactionId);

        $platformPluginMock = Stub::makeEmpty(PlatformPluginInterface::class, [
            'capturePayment' => function (CapturePaymentRequestTransfer $capturePaymentRequestTransfer) use ($capturePaymentResponseTransfer) {
                $this->assertInstanceOf(AppConfigTransfer::class, $capturePaymentRequestTransfer->getAppConfig());
                $this->assertInstanceOf(PaymentTransfer::class, $capturePaymentRequestTransfer->getPayment());

                return $capturePaymentResponseTransfer;
            },
        ]);

        $this->getDependencyHelper()->setDependency(PaymentDependencyProvider::PLUGIN_PLATFORM, $platformPluginMock);

        // Act: This will trigger the MessageHandlerPlugin for this message.
        $this->tester->runMessageReceiveTest($paymentConfirmationRequestedTransfer, 'payment-commands');

        // Assert
        $this->tester->assertPaymentHasStatus($paymentTransfer, PaymentStatusEnum::STATUS_CAPTURE_REQUESTED);
    }

    /**
     * @deprecated This method will be removed when all Tenants are using the tenantIdentifier instead of the storeReference.
     */
    public function testHandlePaymentConfirmationRequestedMessageUpdatesPaymentToCapturedRequestedWithStoreReference(): void
    {
        // Arrange
        $tenantIdentifier = Uuid::uuid4()->toString();
        $transactionId = Uuid::uuid4()->toString();
        $this->tester->haveAppConfigForTenant($tenantIdentifier);
        $paymentTransfer = $this->tester->havePaymentForTransactionId($transactionId, $tenantIdentifier);

        $paymentConfirmationRequestedTransfer = $this->tester->havePaymentConfirmationRequestedTransfer(['tenantIdentifier' => null, 'storeReference' => $tenantIdentifier, 'orderReference' => $paymentTransfer->getOrderReference()]);

        $capturePaymentResponseTransfer = (new CapturePaymentResponseTransfer())
            ->setIsSuccessful(true)
            ->setTransactionId($transactionId);

        $platformPluginMock = Stub::makeEmpty(PlatformPluginInterface::class, [
            'capturePayment' => function (CapturePaymentRequestTransfer $capturePaymentRequestTransfer) use ($capturePaymentResponseTransfer) {
                $this->assertInstanceOf(AppConfigTransfer::class, $capturePaymentRequestTransfer->getAppConfig());
                $this->assertInstanceOf(PaymentTransfer::class, $capturePaymentRequestTransfer->getPayment());

                return $capturePaymentResponseTransfer;
            },
        ]);

        $this->getDependencyHelper()->setDependency(PaymentDependencyProvider::PLUGIN_PLATFORM, $platformPluginMock);

        // Act: This will trigger the MessageHandlerPlugin for this message.
        $this->tester->runMessageReceiveTest($paymentConfirmationRequestedTransfer, 'payment-commands');

        // Assert
        $this->tester->assertPaymentHasStatus($paymentTransfer, PaymentStatusEnum::STATUS_CAPTURE_REQUESTED);
    }

    public function testHandlePaymentConfirmationRequestedThrowsExceptionWhenPaymentDoesNotExist(): void
    {
        // Arrange
        $tenantIdentifier = Uuid::uuid4()->toString();
        $this->tester->haveAppConfigForTenant($tenantIdentifier);

        $paymentConfirmationRequestedTransfer = $this->tester->havePaymentConfirmationRequestedTransfer(['tenantIdentifier' => $tenantIdentifier, 'orderReference' => Uuid::uuid4()->toString()]);

        $this->expectException(PaymentByTenantIdentifierAndOrderReferenceNotFoundException::class);

        // Act
        $this->tester->runMessageReceiveTest($paymentConfirmationRequestedTransfer, 'payment-commands');
    }

    public function testHandlePaymentConfirmationRequestedDoesNotUpdatePaymentStatusWhenPlatformPluginThrowsException(): void
    {
        // Arrange
        $tenantIdentifier = Uuid::uuid4()->toString();
        $transactionId = Uuid::uuid4()->toString();
        $this->tester->haveAppConfigForTenant($tenantIdentifier);
        $paymentTransfer = $this->tester->havePaymentForTransactionId($transactionId, $tenantIdentifier);

        $paymentConfirmationRequestedTransfer = $this->tester->havePaymentConfirmationRequestedTransfer(['tenantIdentifier' => $tenantIdentifier, 'orderReference' => $paymentTransfer->getOrderReference()]);

        $platformPluginMock = Stub::makeEmpty(PlatformPluginInterface::class, [
            'capturePayment' => static function (): never {
                throw new Exception();
            },
        ]);

        $this->getDependencyHelper()->setDependency(PaymentDependencyProvider::PLUGIN_PLATFORM, $platformPluginMock);

        // Act
        $this->tester->runMessageReceiveTest($paymentConfirmationRequestedTransfer, 'payment-commands');

        // Assert
        $this->tester->assertPaymentHasStatus($paymentTransfer, $paymentTransfer->getStatus());
    }
}
