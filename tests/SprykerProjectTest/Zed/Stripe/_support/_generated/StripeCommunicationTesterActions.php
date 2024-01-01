<?php  //[STAMP] a4ea94fafe9969b1dabafb360a1c71c1
// phpcs:ignoreFile
namespace SprykerProjectTest\Zed\Stripe\_generated;

// This class was automatically generated by build task
// You should not change it manually as it will be overwritten on next build

trait StripeCommunicationTesterActions
{
    /**
     * @return \Codeception\Scenario
     */
    abstract protected function getScenario();

    
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @param array|string $appConfiguration
     * @see \SprykerProjectTest\Shared\AppConfig\Helper\AppConfigHelper::haveAppConfigForTenant()
     */
    public function haveAppConfigForTenant(string $tenantIdentifier, ?array $appConfiguration = NULL): \Generated\Shared\Transfer\AppConfigTransfer {
        return $this->getScenario()->runStep(new \Codeception\Step\Action('haveAppConfigForTenant', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @param array|string $expectedAppConfig
     * @see \SprykerProjectTest\Shared\AppConfig\Helper\AppConfigHelper::assertAppConfigForTenantEquals()
     */
    public function assertAppConfigForTenantEquals(string $tenantIdentifier, ?array $expectedAppConfig = NULL): void {
        $this->getScenario()->runStep(new \Codeception\Step\Action('assertAppConfigForTenantEquals', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     *
     * @see \SprykerProjectTest\Shared\AppConfig\Helper\AppConfigHelper::assertAppConfigForTenantIsInState()
     */
    public function assertAppConfigForTenantIsInState(string $tenantIdentifier, string $state): void {
        $this->getScenario()->runStep(new \Codeception\Step\Action('assertAppConfigForTenantIsInState', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     *
     * @see \SprykerProjectTest\Shared\AppConfig\Helper\AppConfigHelper::assertAppConfigurationForTenantDoesNotExist()
     */
    public function assertAppConfigurationForTenantDoesNotExist(string $tenantIdentifier): void {
        $this->getScenario()->runStep(new \Codeception\Step\Action('assertAppConfigurationForTenantDoesNotExist', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @return array<array>
     * @see \SprykerProjectTest\Shared\AppConfig\Helper\AppConfigHelper::getAppConfigureRequestData()
     */
    public function getAppConfigureRequestData(): array {
        return $this->getScenario()->runStep(new \Codeception\Step\Action('getAppConfigureRequestData', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     *
     * @see \SprykerProjectTest\Shared\Payment\Helper\PaymentHelper::assertPaymentIsInState()
     */
    public function assertPaymentIsInState(string $transactionId, string $expectedState): void {
        $this->getScenario()->runStep(new \Codeception\Step\Action('assertPaymentIsInState', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     *
     * @see \SprykerProjectTest\Shared\Payment\Helper\PaymentHelper::havePaymentForTransactionId()
     */
    public function havePaymentForTransactionId(string $transactionId, string $tenantIdentifier, string $status = \SprykerProject\Zed\Payment\Business\Payment\Status\PaymentStatusEnum::STATUS_NEW): \Generated\Shared\Transfer\PaymentTransfer {
        return $this->getScenario()->runStep(new \Codeception\Step\Action('havePaymentForTransactionId', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     *
     * @see \SprykerProjectTest\Shared\Payment\Helper\PaymentHelper::haveInitializePaymentRequestTransfer()
     */
    public function haveInitializePaymentRequestTransfer(array $seed = []): \Generated\Shared\Transfer\InitializePaymentRequestTransfer {
        return $this->getScenario()->runStep(new \Codeception\Step\Action('haveInitializePaymentRequestTransfer', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * This method should only be used by the PlatformPluginInterface implementation tests.
     * It Provides a request transfer as it would come from the Payment module.
     * @see \SprykerProjectTest\Shared\Payment\Helper\PaymentHelper::haveInitializePaymentRequestWithAppConfigTransfer()
     */
    public function haveInitializePaymentRequestWithAppConfigTransfer(array $seed = []): \Generated\Shared\Transfer\InitializePaymentRequestTransfer {
        return $this->getScenario()->runStep(new \Codeception\Step\Action('haveInitializePaymentRequestWithAppConfigTransfer', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     *
     * @see \SprykerProjectTest\Shared\Payment\Helper\PaymentHelper::havePaymentPageRequestTransfer()
     */
    public function havePaymentPageRequestTransfer(array $seed = []): \Generated\Shared\Transfer\PaymentPageRequestTransfer {
        return $this->getScenario()->runStep(new \Codeception\Step\Action('havePaymentPageRequestTransfer', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     *
     * @see \SprykerProjectTest\Shared\Payment\Helper\PaymentHelper::haveCapturePaymentRequestTransfer()
     */
    public function haveCapturePaymentRequestTransfer(array $seed = []): \Generated\Shared\Transfer\CapturePaymentRequestTransfer {
        return $this->getScenario()->runStep(new \Codeception\Step\Action('haveCapturePaymentRequestTransfer', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     *
     * @see \SprykerProjectTest\Shared\Payment\Helper\PaymentHelper::getPaymentTransferByTransactionId()
     */
    public function getPaymentTransferByTransactionId(string $transactionId): \Generated\Shared\Transfer\PaymentTransfer {
        return $this->getScenario()->runStep(new \Codeception\Step\Action('getPaymentTransferByTransactionId', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     *
     * @see \SprykerProjectTest\Zed\Stripe\Helper\StripeHelper::assertConfigurationValidateResponseHasTranslatedErrorMessage()
     */
    public function assertConfigurationValidateResponseHasTranslatedErrorMessage(\Generated\Shared\Transfer\AppConfigValidateResponseTransfer $appConfigValidateResponseTransfer, string $field, string $message): void {
        $this->getScenario()->runStep(new \Codeception\Step\Action('assertConfigurationValidateResponseHasTranslatedErrorMessage', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     *
     * @see \SprykerProjectTest\Zed\Stripe\Helper\StripeHelper::assertConfigurationValidateResponseDoesNotHaveTranslatedErrorMessage()
     */
    public function assertConfigurationValidateResponseDoesNotHaveTranslatedErrorMessage(\Generated\Shared\Transfer\AppConfigValidateResponseTransfer $appConfigValidateResponseTransfer, string $field, string $message): void {
        $this->getScenario()->runStep(new \Codeception\Step\Action('assertConfigurationValidateResponseDoesNotHaveTranslatedErrorMessage', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * This mocks the PaymentIntent class which gets returned from the call to StripeClient::paymentIntents.
     * @see \SprykerProjectTest\Zed\Stripe\Helper\StripeHelper::mockStripeAccountsResponse()
     */
    public function mockStripeAccountsResponse(bool $accountExists): void {
        $this->getScenario()->runStep(new \Codeception\Step\Action('mockStripeAccountsResponse', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * This mocks the PaymentIntent class which gets returned from the call to StripeClient::paymentIntents.
     *
     * @param array $paymentIntentMock Use this for the Stub to mock methods or properties of the PaymentIntent class.
     * @param array $constructorArgs Use this for the Stub to be constructed.
     * @see \SprykerProjectTest\Zed\Stripe\Helper\StripeHelper::mockPaymentIntentResponse()
     */
    public function mockPaymentIntentResponse(array $paymentIntentMock, array $constructorArgs, string $paymentIntentMethod): void {
        $this->getScenario()->runStep(new \Codeception\Step\Action('mockPaymentIntentResponse', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * This mocks the PaymentIntent class which will always throw an ApiErrorException.
     * @see \SprykerProjectTest\Zed\Stripe\Helper\StripeHelper::mockPaymentIntentThatThrowsAnExceptionOnMethodCall()
     */
    public function mockPaymentIntentThatThrowsAnExceptionOnMethodCall(string $exceptionThrowingPaymentIntentMethod): void {
        $this->getScenario()->runStep(new \Codeception\Step\Action('mockPaymentIntentThatThrowsAnExceptionOnMethodCall', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     *
     * @see \SprykerProjectTest\Zed\Stripe\Helper\StripeHelper::getExpectedMetadata()
     */
    public function getExpectedMetadata(): \Stripe\StripeObject {
        return $this->getScenario()->runStep(new \Codeception\Step\Action('getExpectedMetadata', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * This method creates a webhook request transfer from a payload fixture.
     * It also creates a tenant and a payment for the transaction id.
     * The tenant identifier is added to the webhook request transfer.
     * The payment is added to the webhook request transfer.
     * The transaction id is added to the webhook request transfer.
     * The webhook request transfer is returned.
     * @see \SprykerProjectTest\Zed\Stripe\Helper\StripeWebhookHelper::getWebhookRequestTransfer()
     */
    public function getWebhookRequestTransfer(string $payloadFixture): \Generated\Shared\Transfer\WebhookRequestTransfer {
        return $this->getScenario()->runStep(new \Codeception\Step\Action('getWebhookRequestTransfer', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     *
     * @see \SprykerProjectTest\Zed\Stripe\Helper\StripeWebhookHelper::getGlueRequestTransfer()
     */
    public function getGlueRequestTransfer(string $payloadFixture): \Generated\Shared\Transfer\GlueRequestTransfer {
        return $this->getScenario()->runStep(new \Codeception\Step\Action('getGlueRequestTransfer', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @param string $methodName
     * @param mixed $return
     * @param string|null $moduleName
     *
     * @throws \Exception
     *
     * @return \Spryker\Zed\Kernel\Business\AbstractFacade
     * @see \SprykerTest\Zed\Testify\Helper\Business\BusinessHelper::mockFacadeMethod()
     */
    public function mockFacadeMethod(string $methodName, $return, ?string $moduleName = NULL) {
        return $this->getScenario()->runStep(new \Codeception\Step\Action('mockFacadeMethod', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @param string|null $moduleName
     *
     * @return \Spryker\Zed\Kernel\Business\AbstractFacade
     * @see \SprykerTest\Zed\Testify\Helper\Business\BusinessHelper::getFacade()
     */
    public function getFacade(?string $moduleName = NULL): \Spryker\Zed\Kernel\Business\AbstractFacade {
        return $this->getScenario()->runStep(new \Codeception\Step\Action('getFacade', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @param string $methodName
     * @param mixed $return
     * @param string|null $moduleName
     *
     * @throws \Exception
     *
     * @return \Spryker\Zed\Kernel\Business\AbstractBusinessFactory|object
     * @see \SprykerTest\Zed\Testify\Helper\Business\BusinessHelper::mockFactoryMethod()
     */
    public function mockFactoryMethod(string $methodName, $return, ?string $moduleName = NULL) {
        return $this->getScenario()->runStep(new \Codeception\Step\Action('mockFactoryMethod', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @param string $methodName
     * @param mixed $return
     * @param string|null $moduleName
     *
     * @throws \Exception
     *
     * @return \Spryker\Zed\Kernel\Business\AbstractBusinessFactory|object
     * @see \SprykerTest\Zed\Testify\Helper\Business\BusinessHelper::mockSharedFactoryMethod()
     */
    public function mockSharedFactoryMethod(string $methodName, $return, ?string $moduleName = NULL) {
        return $this->getScenario()->runStep(new \Codeception\Step\Action('mockSharedFactoryMethod', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @param string|null $moduleName
     *
     * @return \Spryker\Zed\Kernel\Business\AbstractBusinessFactory
     * @see \SprykerTest\Zed\Testify\Helper\Business\BusinessHelper::getFactory()
     */
    public function getFactory(?string $moduleName = NULL): \Spryker\Zed\Kernel\Business\AbstractBusinessFactory {
        return $this->getScenario()->runStep(new \Codeception\Step\Action('getFactory', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @return void
     * @see \SprykerTest\Shared\Testify\Helper\DependencyHelper::clearFactoryContainerCache()
     */
    public function clearFactoryContainerCache(): void {
        $this->getScenario()->runStep(new \Codeception\Step\Action('clearFactoryContainerCache', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @param string $key
     * @param mixed $value
     * @param string|null $onlyFor
     *
     * @return void
     * @see \SprykerTest\Shared\Testify\Helper\DependencyHelper::setDependency()
     */
    public function setDependency(string $key, $value, ?string $onlyFor = NULL): void {
        $this->getScenario()->runStep(new \Codeception\Step\Action('setDependency', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     *
     * @see \SprykerProjectTest\AsyncApi\Payment\Helper\PaymentHelper::havePaymentCancelReservationRequestedTransfer()
     */
    public function havePaymentCancelReservationRequestedTransfer(array $seed = []): \Generated\Shared\Transfer\PaymentCancelReservationRequestedTransfer {
        return $this->getScenario()->runStep(new \Codeception\Step\Action('havePaymentCancelReservationRequestedTransfer', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     *
     * @see \SprykerProjectTest\AsyncApi\Payment\Helper\PaymentHelper::havePaymentConfirmationRequestedTransfer()
     */
    public function havePaymentConfirmationRequestedTransfer(array $seed = []): \Generated\Shared\Transfer\PaymentConfirmationRequestedTransfer {
        return $this->getScenario()->runStep(new \Codeception\Step\Action('havePaymentConfirmationRequestedTransfer', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     *
     * @see \SprykerProjectTest\AsyncApi\Payment\Helper\PaymentHelper::havePaymentRefundRequestedTransfer()
     */
    public function havePaymentRefundRequestedTransfer(array $seed = []): \Generated\Shared\Transfer\PaymentRefundRequestedTransfer {
        return $this->getScenario()->runStep(new \Codeception\Step\Action('havePaymentRefundRequestedTransfer', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     *
     * @see \SprykerProjectTest\AsyncApi\Payment\Helper\PaymentHelper::havePaymentPreauthorizedTransfer()
     */
    public function havePaymentPreauthorizedTransfer(array $seed = []): \Generated\Shared\Transfer\PaymentPreauthorizedTransfer {
        return $this->getScenario()->runStep(new \Codeception\Step\Action('havePaymentPreauthorizedTransfer', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     *
     * @see \SprykerProjectTest\AsyncApi\Payment\Helper\PaymentHelper::havePaymentConfirmedTransfer()
     */
    public function havePaymentConfirmedTransfer(array $seed = []): \Generated\Shared\Transfer\PaymentConfirmedTransfer {
        return $this->getScenario()->runStep(new \Codeception\Step\Action('havePaymentConfirmedTransfer', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     *
     * @see \SprykerProjectTest\AsyncApi\Payment\Helper\PaymentHelper::havePaymentConfirmationFailedTransfer()
     */
    public function havePaymentConfirmationFailedTransfer(array $seed = []): \Generated\Shared\Transfer\PaymentConfirmationFailedTransfer {
        return $this->getScenario()->runStep(new \Codeception\Step\Action('havePaymentConfirmationFailedTransfer', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     *
     * @see \SprykerProjectTest\AsyncApi\Payment\Helper\PaymentHelper::havePaymentRefundedTransfer()
     */
    public function havePaymentRefundedTransfer(array $seed = []): \Generated\Shared\Transfer\PaymentRefundedTransfer {
        return $this->getScenario()->runStep(new \Codeception\Step\Action('havePaymentRefundedTransfer', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     *
     * @see \SprykerProjectTest\AsyncApi\Payment\Helper\PaymentHelper::havePaymentRefundFailedTransfer()
     */
    public function havePaymentRefundFailedTransfer(array $seed = []): \Generated\Shared\Transfer\PaymentRefundFailedTransfer {
        return $this->getScenario()->runStep(new \Codeception\Step\Action('havePaymentRefundFailedTransfer', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     *
     * @see \SprykerProjectTest\AsyncApi\Payment\Helper\PaymentHelper::havePaymentReservationCanceledTransfer()
     */
    public function havePaymentReservationCanceledTransfer(array $seed = []): \Generated\Shared\Transfer\PaymentReservationCanceledTransfer {
        return $this->getScenario()->runStep(new \Codeception\Step\Action('havePaymentReservationCanceledTransfer', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     *
     * @see \SprykerProjectTest\AsyncApi\Payment\Helper\PaymentHelper::havePaymentMethodAddedTransfer()
     */
    public function havePaymentMethodAddedTransfer(array $seed = []): \Generated\Shared\Transfer\PaymentMethodAddedTransfer {
        return $this->getScenario()->runStep(new \Codeception\Step\Action('havePaymentMethodAddedTransfer', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     *
     * @see \SprykerProjectTest\AsyncApi\Payment\Helper\PaymentHelper::havePaymentMethodDeletedTransfer()
     */
    public function havePaymentMethodDeletedTransfer(array $seed = []): \Generated\Shared\Transfer\PaymentMethodDeletedTransfer {
        return $this->getScenario()->runStep(new \Codeception\Step\Action('havePaymentMethodDeletedTransfer', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @param string $key
     * @param array|string|float|int|bool $value
     *
     * @return void
     * @see \SprykerTest\Shared\Testify\Helper\ConfigHelper::setConfig()
     */
    public function setConfig(string $key, $value): void {
        $this->getScenario()->runStep(new \Codeception\Step\Action('setConfig', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @param string $key
     * @param array|string|float|int|bool $value
     *
     * @return void
     * @see \SprykerTest\Shared\Testify\Helper\ConfigHelper::mockEnvironmentConfig()
     */
    public function mockEnvironmentConfig(string $key, $value): void {
        $this->getScenario()->runStep(new \Codeception\Step\Action('mockEnvironmentConfig', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @param string $methodName
     * @param mixed $return
     * @param string|null $moduleName
     * @param string|null $applicationName
     *
     * @throws \Exception
     *
     * @return \Spryker\Shared\Kernel\AbstractBundleConfig|null
     * @see \SprykerTest\Shared\Testify\Helper\ConfigHelper::mockConfigMethod()
     */
    public function mockConfigMethod(string $methodName, $return, ?string $moduleName = NULL, ?string $applicationName = NULL): ?\Spryker\Shared\Kernel\AbstractBundleConfig {
        return $this->getScenario()->runStep(new \Codeception\Step\Action('mockConfigMethod', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @param string $methodName
     * @param mixed $return
     * @param string|null $moduleName
     *
     * @throws \Exception
     *
     * @return \Spryker\Shared\Kernel\AbstractSharedConfig|null
     * @see \SprykerTest\Shared\Testify\Helper\ConfigHelper::mockSharedConfigMethod()
     */
    public function mockSharedConfigMethod(string $methodName, $return, ?string $moduleName = NULL): ?\Spryker\Shared\Kernel\AbstractSharedConfig {
        return $this->getScenario()->runStep(new \Codeception\Step\Action('mockSharedConfigMethod', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @param string|null $moduleName
     *
     * @return \Spryker\Shared\Kernel\AbstractBundleConfig
     * @see \SprykerTest\Shared\Testify\Helper\ConfigHelper::getModuleConfig()
     */
    public function getModuleConfig(?string $moduleName = NULL): \Spryker\Shared\Kernel\AbstractBundleConfig {
        return $this->getScenario()->runStep(new \Codeception\Step\Action('getModuleConfig', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @param string|null $moduleName
     *
     * @return \Spryker\Shared\Kernel\AbstractSharedConfig|null
     * @see \SprykerTest\Shared\Testify\Helper\ConfigHelper::getSharedModuleConfig()
     */
    public function getSharedModuleConfig(?string $moduleName = NULL): ?\Spryker\Shared\Kernel\AbstractSharedConfig {
        return $this->getScenario()->runStep(new \Codeception\Step\Action('getSharedModuleConfig', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @param string $moduleName
     *
     * @return bool
     * @see \SprykerTest\Shared\Testify\Helper\ConfigHelper::configExists()
     */
    public function configExists(string $moduleName): bool {
        return $this->getScenario()->runStep(new \Codeception\Step\Action('configExists', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @param string $key
     *
     * @return void
     * @see \SprykerTest\Shared\Testify\Helper\ConfigHelper::removeConfig()
     */
    public function removeConfig(string $key): void {
        $this->getScenario()->runStep(new \Codeception\Step\Action('removeConfig', func_get_args()));
    }
}