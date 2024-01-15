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
use Generated\Shared\Transfer\InitializePaymentRequestTransfer;
use Generated\Shared\Transfer\InitializePaymentResponseTransfer;
use GuzzleHttp\RequestOptions;
use SprykerProject\Zed\Payment\Dependency\Plugin\PlatformPluginInterface;
use SprykerProject\Zed\Payment\PaymentConfig;
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
 * @group InitializePaymentApiTest
 * Add your own group annotations below this line
 */
class InitializePaymentApiTest extends Unit
{
    use DependencyHelperTrait;

    protected PaymentBackendApiTester $tester;

    public function testInitializePaymentPostRequestReturnsHttpResponseCode200AndPersistsQuoteWithTransactionId(): void
    {
        // Arrange
        $transactionId = Uuid::uuid4()->toString();
        $tenantIdentifier = Uuid::uuid4()->toString();

        $this->tester->haveAppConfigForTenant($tenantIdentifier);

        $initializePaymentRequestTransfer = $this->tester->haveInitializePaymentRequestTransfer([InitializePaymentRequestTransfer::TENANT_IDENTIFIER => $tenantIdentifier]);
        $url = $this->tester->buildPaymentUrl();

        $initializePaymentResponseTransfer = new InitializePaymentResponseTransfer();
        $initializePaymentResponseTransfer
            ->setIsSuccessful(true)
            ->setTransactionId($transactionId);

        $platformPluginMock = Stub::makeEmpty(PlatformPluginInterface::class, [
            'initializePayment' => function (InitializePaymentRequestTransfer $initializePaymentRequestTransfer) use ($initializePaymentResponseTransfer) {
                // Ensure that the AppConfig is always passed to the platform plugin.
                $this->assertInstanceOf(AppConfigTransfer::class, $initializePaymentRequestTransfer->getAppConfig());

                return $initializePaymentResponseTransfer;
            },
        ]);

        $this->getDependencyHelper()->setDependency(PaymentDependencyProvider::PLUGIN_PLATFORM, $platformPluginMock);

        // Act
        $this->tester->addHeader(PaymentConfig::HEADER_TENANT_IDENTIFIER, $tenantIdentifier);
        $this->tester->sendPost($url, [RequestOptions::FORM_PARAMS => $initializePaymentRequestTransfer->toArray()]);

        // Assert
        $this->tester->seeResponseCodeIs(Response::HTTP_OK);
        $this->tester->seeResponseIsJson();
        $this->tester->seeResponseJsonContainsPayment();

        $this->tester->assertPaymentWithTransactionIdExists($transactionId);
        $this->tester->assertSamePaymentQuoteAndRequestQuote($transactionId, $initializePaymentRequestTransfer->getOrderData());
    }

    public function testInitializePaymentPostRequestReturnsHttpResponseCode400WhenAnExceptionOccurs(): void
    {
        // Arrange
        $initializePaymentRequestTransfer = $this->tester->haveInitializePaymentRequestTransfer();
        $url = $this->tester->buildPaymentUrl();

        $tenantIdentifier = Uuid::uuid4()->toString();

        $platformPluginMock = Stub::makeEmpty(PlatformPluginInterface::class, [
            'initializePayment' => static function (): never {
                throw new Exception();
            },
        ]);

        $this->getDependencyHelper()->setDependency(PaymentDependencyProvider::PLUGIN_PLATFORM, $platformPluginMock);

        // Act
        $this->tester->addHeader(PaymentConfig::HEADER_TENANT_IDENTIFIER, $tenantIdentifier);
        $this->tester->sendPost($url, [RequestOptions::FORM_PARAMS => $initializePaymentRequestTransfer->toArray()]);

        // Assert
        $this->tester->seeResponseCodeIs(Response::HTTP_BAD_REQUEST);
    }

    public function testInitializePaymentPostRequestReturnsHttpResponseCode400WhenPlatformPaymentInitializationFailed(): void
    {
        // Arrange
        $initializePaymentRequestTransfer = $this->tester->haveInitializePaymentRequestTransfer();
        $url = $this->tester->buildPaymentUrl();

        $tenantIdentifier = Uuid::uuid4()->toString();

        $initializePaymentResponseTransfer = new InitializePaymentResponseTransfer();
        $initializePaymentResponseTransfer
            ->setIsSuccessful(false);

        $platformPluginMock = Stub::makeEmpty(PlatformPluginInterface::class, [
            'initializePayment' => $initializePaymentResponseTransfer,
        ]);

        $this->getDependencyHelper()->setDependency(PaymentDependencyProvider::PLUGIN_PLATFORM, $platformPluginMock);

        // Act
        $this->tester->addHeader(PaymentConfig::HEADER_TENANT_IDENTIFIER, $tenantIdentifier);
        $this->tester->sendPost($url, [RequestOptions::FORM_PARAMS => $initializePaymentRequestTransfer->toArray()]);

        // Assert
        $this->tester->seeResponseCodeIs(Response::HTTP_BAD_REQUEST);
    }

    public function testInitializePaymentPostRequestReturnsHttpResponseWithErrorMessageWhenAnExceptionOccurs(): void
    {
        // Arrange
        $initializePaymentRequestTransfer = $this->tester->haveInitializePaymentRequestTransfer();
        $url = $this->tester->buildPaymentUrl();

        $tenantIdentifier = Uuid::uuid4()->toString();

        $platformPluginMock = Stub::makeEmpty(PlatformPluginInterface::class, [
            'initializePayment' => static function (): never {
                throw new Exception();
            },
        ]);

        $this->getDependencyHelper()->setDependency(PaymentDependencyProvider::PLUGIN_PLATFORM, $platformPluginMock);

        // Act
        $this->tester->addHeader(PaymentConfig::HEADER_TENANT_IDENTIFIER, $tenantIdentifier);
        $response = $this->tester->sendPost($url, [RequestOptions::FORM_PARAMS => $initializePaymentRequestTransfer->toArray()]);

        // Assert
        $this->tester->seeResponseCodeIs(Response::HTTP_BAD_REQUEST);
        $this->tester->assertResponseHasErrorMessage($response);
    }
}
