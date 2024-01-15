<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace AppPaymentTest\Glue\AppConfig;

use Codeception\Stub;
use Codeception\Test\Unit;
use Exception;
use Generated\Shared\Transfer\AppConfigValidateResponseTransfer;
use Generated\Shared\Transfer\ConfigurationValidationErrorTransfer;
use SprykerProject\Zed\Payment\Dependency\Plugin\PlatformPluginInterface;
use SprykerProject\Zed\Payment\PaymentConfig;
use SprykerProject\Zed\Payment\PaymentDependencyProvider;
use Ramsey\Uuid\Uuid;
use Spryker\Zed\AppKernel\AppKernelConfig;
use SprykerTest\Shared\Testify\Helper\DependencyHelperTrait;
use Symfony\Component\HttpFoundation\Response;

/**
 * Auto-generated group annotations
 *
 * @group AppPaymentTest
 * @group Glue
 * @group AppConfig
 * @group AppConfigTest
 * Add your own group annotations below this line
 */
class AppConfigTest extends Unit
{
    use DependencyHelperTrait;

    protected AppConfigTester $tester;

    public function testReceivingConfigurationFromAppStoreCatalogSavesAppConfigurationWhenPlatformValidationWasSuccessful(): void
    {
        // Arrange
        $tenantIdentifier = Uuid::uuid4()->toString();

        $appConfigValidateResponseTransfer = new AppConfigValidateResponseTransfer();
        $appConfigValidateResponseTransfer->setIsSuccessful(true);

        $platformPluginMock = Stub::makeEmpty(PlatformPluginInterface::class, [
            'validateConfiguration' => $appConfigValidateResponseTransfer,
        ]);

        $this->getDependencyHelper()->setDependency(PaymentDependencyProvider::PLUGIN_PLATFORM, $platformPluginMock);

        $this->tester->setHeaders([
            PaymentConfig::HEADER_TENANT_IDENTIFIER => $tenantIdentifier,
            'Content-Type' => 'application/vnd.api+json',
            'Accept' => 'application/vnd.api+json',
            'Accept-Language' => 'en-US, en;q=0.9,*;q=0.5',
        ]);

        // Act
        $response = $this->tester->sendPost('/private/configure', $this->tester->getAppConfigureRequestData());

        // Assert
        $this->assertSame(200, $response->getStatusCode());
        $this->tester->assertAppConfigForTenantEquals($tenantIdentifier);
    }

    public function testReceivingConfigurationFromAppStoreCatalogSavesAppConfigurationAndUpdatesAppConfigStatusToConnectedAfterThePaymentMethodAddedWasSent(): void
    {
        // Arrange
        $tenantIdentifier = Uuid::uuid4()->toString();

        $appConfigValidateResponseTransfer = new AppConfigValidateResponseTransfer();
        $appConfigValidateResponseTransfer->setIsSuccessful(true);

        $platformPluginMock = Stub::makeEmpty(PlatformPluginInterface::class, [
            'validateConfiguration' => $appConfigValidateResponseTransfer,
        ]);

        $this->getDependencyHelper()->setDependency(PaymentDependencyProvider::PLUGIN_PLATFORM, $platformPluginMock);

        $this->tester->setHeaders([
            PaymentConfig::HEADER_TENANT_IDENTIFIER => $tenantIdentifier,
            'Content-Type' => 'application/vnd.api+json',
            'Accept' => 'application/vnd.api+json',
            'Accept-Language' => 'en-US, en;q=0.9,*;q=0.5',
        ]);

        // Act
        $response = $this->tester->sendPost('/private/configure', $this->tester->getAppConfigureRequestData());

        // Assert
        $this->assertSame(200, $response->getStatusCode());
        $this->tester->assertAppConfigForTenantIsInState($tenantIdentifier, AppKernelConfig::APP_STATUS_CONNECTED);
    }

    public function testReceivingConfigurationFromAppStoreCatalogReturns422UnprocessableEntityWhenPlatformValidationFailed(): void
    {
        // Arrange
        $tenantIdentifier = Uuid::uuid4()->toString();

        $appConfigValidateResponseTransfer = new AppConfigValidateResponseTransfer();
        $appConfigValidateResponseTransfer->setIsSuccessful(false);

        $platformPluginMock = Stub::makeEmpty(PlatformPluginInterface::class, [
            'validateConfiguration' => $appConfigValidateResponseTransfer,
        ]);

        $this->getDependencyHelper()->setDependency(PaymentDependencyProvider::PLUGIN_PLATFORM, $platformPluginMock);

        $this->tester->setHeaders([
            PaymentConfig::HEADER_TENANT_IDENTIFIER => $tenantIdentifier,
            'Content-Type' => 'application/vnd.api+json',
            'Accept' => 'application/vnd.api+json',
            'Accept-Language' => 'en-US, en;q=0.9,*;q=0.5',
        ]);

        // Act
        $response = $this->tester->sendPost('/private/configure', $this->tester->getAppConfigureRequestData());

        // Assert
        $this->assertSame(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
        $this->tester->assertAppConfigurationForTenantDoesNotExist($tenantIdentifier);
    }

    public function testReceivingConfigurationFromAppStoreCatalogReturns422UnprocessableEntityWithErrorMessagesWhenPlatformValidationFailed(): void
    {
        // Arrange
        $tenantIdentifier = Uuid::uuid4()->toString();

        $configurationValidationErrorTransfer = new ConfigurationValidationErrorTransfer();
        $configurationValidationErrorTransfer->addErrorMessage('Something went wrong');

        $appConfigValidateResponseTransfer = new AppConfigValidateResponseTransfer();
        $appConfigValidateResponseTransfer
            ->setIsSuccessful(false)
            ->addConfigurationValidationError($configurationValidationErrorTransfer);

        $platformPluginMock = Stub::makeEmpty(PlatformPluginInterface::class, [
            'validateConfiguration' => $appConfigValidateResponseTransfer,
        ]);

        $this->getDependencyHelper()->setDependency(PaymentDependencyProvider::PLUGIN_PLATFORM, $platformPluginMock);

        $this->tester->setHeaders([
            PaymentConfig::HEADER_TENANT_IDENTIFIER => $tenantIdentifier,
            'Content-Type' => 'application/vnd.api+json',
            'Accept' => 'application/vnd.api+json',
            'Accept-Language' => 'en-US, en;q=0.9,*;q=0.5',
        ]);

        // Act
        $response = $this->tester->sendPost('/private/configure', $this->tester->getAppConfigureRequestData());

        // Assert
        $this->assertSame(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
        $this->tester->assertAppConfigurationForTenantDoesNotExist($tenantIdentifier);
    }

    public function testReceivingConfigurationFromAppStoreCatalogReturns422UnprocessableEntityWithErrorMessagesWhenPlatformValidationThrowsAnException(): void
    {
        // Arrange
        $tenantIdentifier = Uuid::uuid4()->toString();

        $platformPluginMock = Stub::makeEmpty(PlatformPluginInterface::class, [
            'validateConfiguration' => static function (): never {
                throw new Exception('Something went wrong');
            },
        ]);

        $this->getDependencyHelper()->setDependency(PaymentDependencyProvider::PLUGIN_PLATFORM, $platformPluginMock);

        $this->tester->setHeaders([
            PaymentConfig::HEADER_TENANT_IDENTIFIER => $tenantIdentifier,
            'Content-Type' => 'application/vnd.api+json',
            'Accept' => 'application/vnd.api+json',
            'Accept-Language' => 'en-US, en;q=0.9,*;q=0.5',
        ]);

        // Act
        $response = $this->tester->sendPost('/private/configure', $this->tester->getAppConfigureRequestData());

        // Assert
        $this->assertSame(Response::HTTP_INTERNAL_SERVER_ERROR, $response->getStatusCode());
        $this->tester->assertAppConfigurationForTenantDoesNotExist($tenantIdentifier);
    }

    public function testDisconnectAppForAnExistingTenantRemovesAppConfiguration(): void
    {
        // Arrange
        $tenantIdentifier = Uuid::uuid4()->toString();

        $this->tester->haveAppConfigForTenant($tenantIdentifier);
        $this->tester->assertAppConfigForTenantEquals($tenantIdentifier);

        $appConfigValidateResponseTransfer = new AppConfigValidateResponseTransfer();
        $appConfigValidateResponseTransfer->setIsSuccessful(false);

        $platformPluginMock = Stub::makeEmpty(PlatformPluginInterface::class, [
            'validateConfiguration' => $appConfigValidateResponseTransfer,
        ]);

        $this->getDependencyHelper()->setDependency(PaymentDependencyProvider::PLUGIN_PLATFORM, $platformPluginMock);

        $this->tester->setHeaders([
            PaymentConfig::HEADER_TENANT_IDENTIFIER => $tenantIdentifier,
            'Content-Type' => 'application/vnd.api+json',
            'Accept' => 'application/vnd.api+json',
            'Accept-Language' => 'en-US, en;q=0.9,*;q=0.5',
        ]);

        // Act
        $response = $this->tester->sendPost('/private/disconnect');

        // Assert
        $this->assertSame(204, $response->getStatusCode());
        $this->tester->assertAppConfigurationForTenantDoesNotExist($tenantIdentifier);
    }

    public function testDisconnectAppForAnExistingTenantWhenNoContentTypeHeaderIsProvidedRemovesAppConfiguration(): void
    {
        // Arrange
        $tenantIdentifier = Uuid::uuid4()->toString();

        $this->tester->haveAppConfigForTenant($tenantIdentifier);
        $this->tester->assertAppConfigForTenantEquals($tenantIdentifier);

        $appConfigValidateResponseTransfer = new AppConfigValidateResponseTransfer();
        $appConfigValidateResponseTransfer->setIsSuccessful(false);

        $platformPluginMock = Stub::makeEmpty(PlatformPluginInterface::class, [
            'validateConfiguration' => $appConfigValidateResponseTransfer,
        ]);

        $this->getDependencyHelper()->setDependency(PaymentDependencyProvider::PLUGIN_PLATFORM, $platformPluginMock);

        $this->tester->setHeaders([
            PaymentConfig::HEADER_TENANT_IDENTIFIER => $tenantIdentifier,
            'Accept-Language' => 'en-US, en;q=0.9,*;q=0.5',
        ]);

        // Act
        $response = $this->tester->sendPost('/private/disconnect');

        // Assert
        $this->assertSame(204, $response->getStatusCode());
        $this->tester->assertAppConfigurationForTenantDoesNotExist($tenantIdentifier);
    }
}
