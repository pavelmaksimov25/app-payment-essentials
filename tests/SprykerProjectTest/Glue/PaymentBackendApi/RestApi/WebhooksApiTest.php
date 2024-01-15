<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace AppPaymentTest\Glue\PaymentBackendApi\RestApi;

use Codeception\Stub;
use Codeception\Test\Unit;
use Exception;
use Generated\Shared\Transfer\AppConfigTransfer;
use Generated\Shared\Transfer\GlueRequestTransfer;
use Generated\Shared\Transfer\PaymentTransfer;
use Generated\Shared\Transfer\WebhookRequestTransfer;
use Generated\Shared\Transfer\WebhookResponseTransfer;
use SprykerProject\Glue\PaymentBackendApi\PaymentBackendApiDependencyProvider;
use SprykerProject\Glue\PaymentBackendApi\Plugin\PaymentBackendApi\GlueRequestWebhookMapperPluginInterface;
use SprykerProject\Zed\Payment\Business\Message\MessageBuilder;
use SprykerProject\Zed\Payment\Business\Payment\Status\PaymentStatusEnum;
use SprykerProject\Zed\Payment\Dependency\Plugin\PlatformPluginInterface;
use SprykerProject\Zed\Payment\Dependency\Plugin\PlatformPluginTransactionIdAwareInterface;
use SprykerProject\Zed\Payment\PaymentDependencyProvider;
use AppPaymentTest\Glue\PaymentBackendApi\PaymentBackendApiTester;
use Ramsey\Uuid\Uuid;
use SprykerTest\Shared\Testify\Helper\DependencyHelperTrait;
use Symfony\Component\HttpFoundation\Response;

/**
 * Auto-generated group annotations
 *
 * @group AppPaymentTest
 * @group Glue
 * @group PaymentBackendApi
 * @group RestApi
 * @group WebhooksApiTest
 * Add your own group annotations below this line
 */
class WebhooksApiTest extends Unit
{
    use DependencyHelperTrait;

    protected PaymentBackendApiTester $tester;

    public function testHandleWebhookReturnsA200OKWhenThePlatformPluginInterfaceImplementationReturnsASuccessfulWebhookResponseTransferAndAuthorizedStatus(): void
    {
        // Arrange
        $transactionId = Uuid::uuid4()->toString();
        $tenantIdentifier = Uuid::uuid4()->toString();

        $this->tester->haveAppConfigForTenant($tenantIdentifier);
        $this->tester->havePaymentForTransactionId($transactionId, $tenantIdentifier);

        $this->mockPaymentPlatformTransactionIdAware($transactionId, true, PaymentStatusEnum::STATUS_AUTHORIZED);

        // Act
        $this->tester->sendPost($this->tester->buildWebhookUrl(), ['web hook content received from third party payment provider']);

        // Assert
        $this->tester->seeResponseCodeIs(Response::HTTP_OK);
    }

    public function testHandleWebhookReturnsA200OKWhenThePlatformPluginInterfaceImplementationReturnsASuccessfulWebhookResponseTransfer(): void
    {
        // Arrange
        $transactionId = Uuid::uuid4()->toString();
        $tenantIdentifier = Uuid::uuid4()->toString();

        $this->tester->haveAppConfigForTenant($tenantIdentifier);
        $this->tester->havePaymentForTransactionId($transactionId, $tenantIdentifier);

        $this->mockPaymentPlatformTransactionIdAware($transactionId, true, PaymentStatusEnum::STATUS_CAPTURED);

        // Act
        $this->tester->sendPost($this->tester->buildWebhookUrl(), ['web hook content received from third party payment provider']);

        // Assert
        $this->tester->seeResponseCodeIs(Response::HTTP_OK);
    }

    public function testHandleWebhookReturnsA200OKWhenTheTransactionIdWasResolvedByTheGlueRequestWebhookMapperAndThePlatformPluginInterfaceImplementationReturnsASuccessfulWebhookResponseTransfer(): void
    {
        // Arrange
        $transactionId = Uuid::uuid4()->toString();
        $tenantIdentifier = Uuid::uuid4()->toString();

        $this->tester->haveAppConfigForTenant($tenantIdentifier);
        $this->tester->havePaymentForTransactionId($transactionId, $tenantIdentifier);

        $this->getDependencyHelper()->setDependency(PaymentBackendApiDependencyProvider::PLUGIN_GLUE_REQUEST_WEBHOOK_MAPPER, new class ($transactionId) implements GlueRequestWebhookMapperPluginInterface {
            public function __construct(protected string $transactionId)
            {
            }

            public function mapGlueRequestDataToWebhookRequestTransfer(
                GlueRequestTransfer $glueRequestTransfer,
                WebhookRequestTransfer $webhookRequestTransfer
            ): WebhookRequestTransfer {
                $webhookRequestTransfer->setTransactionId($this->transactionId);

                return $webhookRequestTransfer;
            }
        });

        $this->mockPaymentPlatform($transactionId, true, PaymentStatusEnum::STATUS_CAPTURED);

        // Act
        $this->tester->sendPost($this->tester->buildWebhookUrl(), ['web hook content received from third party payment provider']);

        // Assert
        $this->tester->seeResponseCodeIs(Response::HTTP_OK);
    }

    public function testHandleWebhookReturnsA400BadRequestWhenTheTransactionIdCouldNotBeExtractedFromTheWebhookRequest(): void
    {
        // Arrange
        $transactionId = Uuid::uuid4()->toString();
        $tenantIdentifier = Uuid::uuid4()->toString();

        $this->tester->haveAppConfigForTenant($tenantIdentifier);
        $this->tester->havePaymentForTransactionId($transactionId, $tenantIdentifier);

        $this->mockPaymentPlatform($transactionId, true, PaymentStatusEnum::STATUS_CAPTURED);

        // Act
        $this->tester->sendPost($this->tester->buildWebhookUrl(), ['web hook content received from third party payment provider']);

        // Assert
        $this->tester->seeResponseCodeIs(Response::HTTP_BAD_REQUEST);
        $this->tester->seeResponseContainsErrorMessage(MessageBuilder::getRequestTransactionIdIsMissingOrEmpty());
    }

    /**
     * Just in case, the platform plugin implementation changes the transactionId to a different value.
     */
    public function testHandleWebhookReturnsA400BadRequestWhenTheTransactionIdCouldNotBeFoundWhenPersisting(): void
    {
        // Arrange
        $transactionId = Uuid::uuid4()->toString();
        $tenantIdentifier = Uuid::uuid4()->toString();

        $this->tester->haveAppConfigForTenant($tenantIdentifier);
        $this->tester->havePaymentForTransactionId($transactionId, $tenantIdentifier);

        $this->mockPaymentPlatformWithInvalidTransactionIdChange($transactionId, true, PaymentStatusEnum::STATUS_CAPTURED);

        // Act
        $this->tester->sendPost($this->tester->buildWebhookUrl(), ['web hook content received from third party payment provider']);

        // Assert
        $this->tester->seeResponseCodeIs(Response::HTTP_BAD_REQUEST);
        $this->tester->seeResponseContainsErrorMessage(MessageBuilder::paymentByTransactionIdNotFound('invalid transaction id'));
    }

    public function testHandleWebhookReturnsA400BadRequestWhenGettingTheTransactionIdThroughThePaymentPlatformPluginThrowsAnException(): void
    {
        // Arrange
        $transactionId = Uuid::uuid4()->toString();
        $tenantIdentifier = Uuid::uuid4()->toString();

        $this->tester->haveAppConfigForTenant($tenantIdentifier);
        $this->tester->havePaymentForTransactionId($transactionId, $tenantIdentifier);

        $this->mockPaymentPlatformThatThrowsAnException();

        // Act
        $this->tester->sendPost($this->tester->buildWebhookUrl(), ['web hook content received from third party payment provider']);

        // Assert
        $this->tester->seeResponseCodeIs(Response::HTTP_BAD_REQUEST);
        $this->tester->seeResponseContainsErrorMessage('PlatformPluginTransactionIdAwareInterface::getTransactionIdFromWebhookData() exception.');
    }

    public function testHandleWebhookTransitionsPaymentToNewStateWhenThePlatformPluginInterfaceImplementationReturnsASuccessfulWebhookResponseTransferAndThePaymentCanBeTransitionedToTheDesiredState(): void
    {
        // Arrange
        $transactionId = Uuid::uuid4()->toString();
        $tenantIdentifier = Uuid::uuid4()->toString();

        $this->tester->haveAppConfigForTenant($tenantIdentifier);
        $this->tester->havePaymentForTransactionId($transactionId, $tenantIdentifier);

        $this->mockPaymentPlatformTransactionIdAware($transactionId, true, PaymentStatusEnum::STATUS_CAPTURED);

        // Act
        $this->tester->sendPost($this->tester->buildWebhookUrl(), ['web hook content received from third party payment provider']);

        // Assert
        $this->tester->assertPaymentIsInState($transactionId, PaymentStatusEnum::STATUS_CAPTURED);
    }

    public function testHandleWebhookReturnsA400WhenThePlatformPluginInterfaceImplementationReturnsAFailedWebhookResponseTransfer(): void
    {
        // Arrange
        $transactionId = Uuid::uuid4()->toString();
        $tenantIdentifier = Uuid::uuid4()->toString();

        $this->tester->haveAppConfigForTenant($tenantIdentifier);
        $this->tester->havePaymentForTransactionId($transactionId, $tenantIdentifier);

        $this->mockPaymentPlatformTransactionIdAware($transactionId, false);

        // Act
        $this->tester->sendPost($this->tester->buildWebhookUrl(), ['web hook content received from third party payment provider']);

        // Assert
        $this->tester->seeResponseCodeIs(Response::HTTP_BAD_REQUEST);
    }

    public function testHandleWebhookDoesNotTransitionPaymentToNewStateWhenThePlatformPluginInterfaceImplementationReturnsAFailedWebhookResponseTransfer(): void
    {
        // Arrange
        $transactionId = Uuid::uuid4()->toString();
        $tenantIdentifier = Uuid::uuid4()->toString();

        $this->tester->haveAppConfigForTenant($tenantIdentifier);
        $this->tester->havePaymentForTransactionId($transactionId, $tenantIdentifier);

        $this->mockPaymentPlatformTransactionIdAware($transactionId, false);

        // Act
        $this->tester->sendPost($this->tester->buildWebhookUrl(), ['web hook content received from third party payment provider']);

        // Assert
        $this->tester->assertPaymentIsInState($transactionId, PaymentStatusEnum::STATUS_NEW);
    }

    public function testHandleWebhookDoesNotTransitionPaymentToNewStateWhenThePlatformPluginInterfaceImplementationReturnsASuccessfulWebhookResponseTransferButTheDesiredTransitionCanNotBeDone(): void
    {
        // Arrange
        $transactionId = Uuid::uuid4()->toString();
        $tenantIdentifier = Uuid::uuid4()->toString();

        $this->tester->haveAppConfigForTenant($tenantIdentifier);
        $this->tester->havePaymentForTransactionId($transactionId, $tenantIdentifier);

        $this->mockPaymentPlatformTransactionIdAware($transactionId, true, 'unknown transition status');

        // Act
        $this->tester->sendPost($this->tester->buildWebhookUrl(), ['web hook content received from third party payment provider']);

        // Assert
        $this->tester->assertPaymentIsInState($transactionId, PaymentStatusEnum::STATUS_NEW);
    }

    public function testHandleWebhookReturnsAFailedWebhookResponseTransferWithTheForwardedExceptionMessageWhenAnExceptionOccurs(): void
    {
        // Arrange
        $transactionId = Uuid::uuid4()->toString();
        $tenantIdentifier = Uuid::uuid4()->toString();

        $this->tester->haveAppConfigForTenant($tenantIdentifier);
        $this->tester->havePaymentForTransactionId($transactionId, $tenantIdentifier);

        $this->mockPaymentPlatformThatThrowsAnException();

        // Act
        $this->tester->sendPost($this->tester->buildWebhookUrl(), ['web hook content received from third party payment provider']);

        // Assert
        $this->tester->seeResponseCodeIs(Response::HTTP_BAD_REQUEST);
        $this->tester->seeResponseContainsErrorMessage('PlatformPluginTransactionIdAwareInterface::getTransactionIdFromWebhookData() exception.');
    }

    public function testHandleWebhookReturnsA400BadRequestWhenTryingToretrieveTheTransactionIdWithGlueRequestTransferToWebhookTransferMapperPluginWhenNoPluginIsConfigured(): void
    {
        // Arrange
        $transactionId = Uuid::uuid4()->toString();
        $tenantIdentifier = Uuid::uuid4()->toString();

        $this->tester->haveAppConfigForTenant($tenantIdentifier);
        $this->tester->havePaymentForTransactionId($transactionId, $tenantIdentifier);

        $this->getDependencyHelper()->setDependency(PaymentBackendApiDependencyProvider::PLUGIN_GLUE_REQUEST_WEBHOOK_MAPPER, null);

        $this->mockPaymentPlatform($transactionId, true, PaymentStatusEnum::STATUS_CAPTURED);

        // Act
        $this->tester->sendPost($this->tester->buildWebhookUrl(), ['web hook content received from third party payment provider']);

        // Assert
        $this->tester->seeResponseCodeIs(Response::HTTP_BAD_REQUEST);
    }

    /**
     * It could happen we receive multiple Webhook requests, with the same event for the same payment, which in that case would result in the payment status not changing.
     */
    public function testHandleWebhookReturnsA200WebhookRequestIsSuccessfulAndPaymentStateDoesNotChange(): void
    {
        // Arrange
        $transactionId = Uuid::uuid4()->toString();
        $tenantIdentifier = Uuid::uuid4()->toString();

        $this->tester->haveAppConfigForTenant($tenantIdentifier);
        $this->tester->havePaymentForTransactionId($transactionId, $tenantIdentifier, PaymentStatusEnum::STATUS_CAPTURED);

        $this->mockPaymentPlatformTransactionIdAware($transactionId, true, PaymentStatusEnum::STATUS_CAPTURED);

        // Act
        $this->tester->sendPost($this->tester->buildWebhookUrl(), ['web hook content received from third party payment provider']);

        // Assert
        $this->tester->assertPaymentIsInState($transactionId, PaymentStatusEnum::STATUS_CAPTURED);
        $this->tester->seeResponseCodeIs(Response::HTTP_OK);
    }

    public function testHandleWebhookReturnsA200OKWhenThePlatformPluginInterfaceImplementationReturnsASuccessfulWebhookResponseTransferAndFailedCaptureStatus(): void
    {
        // Arrange
        $transactionId = Uuid::uuid4()->toString();
        $tenantIdentifier = Uuid::uuid4()->toString();

        $this->tester->haveAppConfigForTenant($tenantIdentifier);
        $this->tester->havePaymentForTransactionId($transactionId, $tenantIdentifier);

        $this->mockPaymentPlatformTransactionIdAware($transactionId, true, PaymentStatusEnum::STATUS_CAPTURE_FAILED);

        // Act
        $this->tester->sendPost($this->tester->buildWebhookUrl(), ['web hook content received from third party payment provider']);

        // Assert
        $this->tester->seeResponseCodeIs(Response::HTTP_OK);
    }

    /**
     * Mock ensures that the Payment module passed the AppConfigTransfer and the PaymentTransfer to the PlatformPlugin.
     * This mock also uses the ˚PaymentPlatformPluginInterface::getTransactionIdFromWebhookData()˚ method to ensure that the PaymentPlatformPluginInterface passes the transactionId to the Payment module.
     */
    protected function mockPaymentPlatformTransactionIdAware(string $transactionId, bool $webhookResponseSuccessful, ?string $paymentStatus = null): void
    {
        $platformPluginMock = Stub::makeEmpty(PlatformPluginTransactionIdAwareInterface::class, [
            'handleWebhook' => function (WebhookRequestTransfer $webhookRequestTransfer) use ($transactionId, $webhookResponseSuccessful, $paymentStatus): WebhookResponseTransfer {
                $webhookResponseTransfer = new WebhookResponseTransfer();
                $webhookResponseTransfer->setIsSuccessful($webhookResponseSuccessful);
                $webhookResponseTransfer->setPaymentStatus($paymentStatus);

                // Ensure that the AppConfig is always passed to the platform plugin.
                $this->assertInstanceOf(AppConfigTransfer::class, $webhookRequestTransfer->getAppConfig());

                // Ensure that the PaymentTransfer is always passed to the platform plugin.
                $this->assertInstanceOf(PaymentTransfer::class, $webhookRequestTransfer->getPayment());

                return $webhookResponseTransfer;
            },
            'getTransactionIdFromWebhookData' => function () use ($transactionId) {
                return $transactionId;
            },
        ]);

        $this->getDependencyHelper()->setDependency(PaymentDependencyProvider::PLUGIN_PLATFORM, $platformPluginMock);
    }

    /**
     * Mock ensures that the Payment module passed the AppConfigTransfer and the PaymentTransfer to the PlatformPlugin.
     * This mock also uses the ˚PaymentPlatformPluginInterface::getTransactionIdFromWebhookData()˚ method to ensure that the PaymentPlatformPluginInterface passes the transactionId to the Payment module.
     */
    protected function mockPaymentPlatformWithInvalidTransactionIdChange(
        string $transactionId,
        bool $webhookResponseSuccessful,
        ?string $paymentStatus = null
    ): void {
        $platformPluginMock = Stub::makeEmpty(PlatformPluginTransactionIdAwareInterface::class, [
            'handleWebhook' => function (WebhookRequestTransfer $webhookRequestTransfer) use ($transactionId, $webhookResponseSuccessful, $paymentStatus): WebhookResponseTransfer {
                $webhookResponseTransfer = new WebhookResponseTransfer();
                $webhookResponseTransfer->setIsSuccessful($webhookResponseSuccessful);
                $webhookResponseTransfer->setPaymentStatus($paymentStatus);

                // Ensure that the AppConfig is always passed to the platform plugin.
                $this->assertInstanceOf(AppConfigTransfer::class, $webhookRequestTransfer->getAppConfig());

                // Ensure that the PaymentTransfer is always passed to the platform plugin.
                $this->assertInstanceOf(PaymentTransfer::class, $webhookRequestTransfer->getPayment());

                // Changing the transaction id from the PlatformPlugin is not allowed and will fail when persisting the payment.
                $webhookRequestTransfer->getPayment()->setTransactionId('invalid transaction id');

                return $webhookResponseTransfer;
            },
            'getTransactionIdFromWebhookData' => function () use ($transactionId) {
                return $transactionId;
            },
        ]);

        $this->getDependencyHelper()->setDependency(PaymentDependencyProvider::PLUGIN_PLATFORM, $platformPluginMock);
    }

    /**
     * Mock ensures that the Payment module passed the AppConfigTransfer and the PaymentTransfer to the PlatformPlugin.
     * This mock also uses the ˚PaymentPlatformPluginInterface::getTransactionIdFromWebhookData()˚ method to ensure that the PaymentPlatformPluginInterface passes the transactionId to the Payment module.
     */
    protected function mockPaymentPlatform(string $transactionId, bool $webhookResponseSuccessful, ?string $paymentStatus = null): void
    {
        $platformPluginMock = Stub::makeEmpty(PlatformPluginInterface::class, [
            'handleWebhook' => function (WebhookRequestTransfer $webhookRequestTransfer) use ($transactionId, $webhookResponseSuccessful, $paymentStatus): WebhookResponseTransfer {
                $webhookResponseTransfer = new WebhookResponseTransfer();
                $webhookResponseTransfer->setIsSuccessful($webhookResponseSuccessful);
                $webhookResponseTransfer->setPaymentStatus($paymentStatus);

                // Ensure that the AppConfig is always passed to the platform plugin.
                $this->assertInstanceOf(AppConfigTransfer::class, $webhookRequestTransfer->getAppConfig());

                // Ensure that the PaymentTransfer is always passed to the platform plugin.
                $this->assertInstanceOf(PaymentTransfer::class, $webhookRequestTransfer->getPayment());

                return $webhookResponseTransfer;
            },
        ]);

        $this->getDependencyHelper()->setDependency(PaymentDependencyProvider::PLUGIN_PLATFORM, $platformPluginMock);
    }

    protected function mockPaymentPlatformThatThrowsAnException(): void
    {
        $platformPluginMock = Stub::makeEmpty(PlatformPluginTransactionIdAwareInterface::class, [
            'handleWebhook' => function (): WebhookResponseTransfer {
                throw new Exception('PaymentPlatformPluginInterface::handleWebhook() exception.');
            },
            'getTransactionIdFromWebhookData' => function (): void {
                throw new Exception('PlatformPluginTransactionIdAwareInterface::getTransactionIdFromWebhookData() exception.');
            },
        ]);

        $this->getDependencyHelper()->setDependency(PaymentDependencyProvider::PLUGIN_PLATFORM, $platformPluginMock);
    }
}
