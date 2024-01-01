<?php  //[STAMP] 62f9e3d2ef7b3cdd578dc0969daa313b
// phpcs:ignoreFile
namespace SprykerProjectTest\Glue\AppConfig\_generated;

// This class was automatically generated by build task
// You should not change it manually as it will be overwritten on next build

trait AppConfigTesterActions
{
    /**
     * @return \Codeception\Scenario
     */
    abstract protected function getScenario();

    
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     *
     * @see \SprykerProjectTest\Glue\PaymentBackendApi\Helper\PaymentBackendApiHelper::buildPaymentUrl()
     */
    public function buildPaymentUrl(): string {
        return $this->getScenario()->runStep(new \Codeception\Step\Action('buildPaymentUrl', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     *
     * @see \SprykerProjectTest\Glue\PaymentBackendApi\Helper\PaymentBackendApiHelper::buildWebhookUrl()
     */
    public function buildWebhookUrl(): string {
        return $this->getScenario()->runStep(new \Codeception\Step\Action('buildWebhookUrl', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     *
     * @see \SprykerProjectTest\Glue\PaymentBackendApi\Helper\PaymentBackendApiHelper::assertPaymentWithTransactionIdExists()
     */
    public function assertPaymentWithTransactionIdExists(string $transactionId): void {
        $this->getScenario()->runStep(new \Codeception\Step\Action('assertPaymentWithTransactionIdExists', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     *
     * @see \SprykerProjectTest\Glue\PaymentBackendApi\Helper\PaymentBackendApiHelper::assertSamePaymentQuoteAndRequestQuote()
     */
    public function assertSamePaymentQuoteAndRequestQuote(string $transactionId, \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer): void {
        $this->getScenario()->runStep(new \Codeception\Step\Action('assertSamePaymentQuoteAndRequestQuote', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     *
     * @see \SprykerProjectTest\Glue\PaymentBackendApi\Helper\PaymentBackendApiHelper::assertResponseHasErrorMessage()
     */
    public function assertResponseHasErrorMessage(\Symfony\Component\HttpFoundation\Response $response): void {
        $this->getScenario()->runStep(new \Codeception\Step\Action('assertResponseHasErrorMessage', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * Sets a class instance into the Locator cache to ensure the mocked instance is returned when
     * `$locator->moduleName()->type()` is used.
     *
     * !!! When this method is used the locator will not re-initialize classes with `new` but will return
     * always the already resolved instances. This can have but should not have side-effects.
     *
     * @param string $cacheKey
     * @param mixed $classInstance
     *
     * @return void
     * @see \SprykerTest\Shared\Testify\Helper\LocatorHelper::addToLocatorCache()
     */
    public function addToLocatorCache(string $cacheKey, $classInstance): void {
        $this->getScenario()->runStep(new \Codeception\Step\Action('addToLocatorCache', func_get_args()));
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
     * @return \Spryker\Shared\Kernel\LocatorLocatorInterface&\Generated\Zed\Ide\AutoCompletion&\Generated\Service\Ide\AutoCompletion&\Generated\Glue\Ide\AutoCompletion
     * @see \SprykerTest\Shared\Testify\Helper\LocatorHelper::getLocator()
     */
    public function getLocator() {
        return $this->getScenario()->runStep(new \Codeception\Step\Action('getLocator', func_get_args()));
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

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @param string $key
     * @param mixed $value
     * @param string|null $onlyFor
     *
     * @return void
     * @see \SprykerTest\Zed\Testify\Helper\AbstractDependencyProviderHelper::setDependency()
     */
    public function setDependency($key, $value, $onlyFor = NULL) {
        return $this->getScenario()->runStep(new \Codeception\Step\Action('setDependency', func_get_args()));
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
     * @return \Spryker\Zed\Kernel\AbstractBundleDependencyProvider
     * @see \SprykerTest\Zed\Testify\Helper\AbstractDependencyProviderHelper::mockDependencyProviderMethod()
     */
    public function mockDependencyProviderMethod(string $methodName, $return, ?string $moduleName = NULL): \Spryker\Zed\Kernel\AbstractBundleDependencyProvider {
        return $this->getScenario()->runStep(new \Codeception\Step\Action('mockDependencyProviderMethod', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @param string|null $moduleName
     *
     * @throws \Exception
     *
     * @return \Spryker\Zed\Kernel\Container
     * @see \SprykerTest\Zed\Testify\Helper\AbstractDependencyProviderHelper::getModuleContainer()
     */
    public function getModuleContainer(?string $moduleName = NULL): \Spryker\Zed\Kernel\Container {
        return $this->getScenario()->runStep(new \Codeception\Step\Action('getModuleContainer', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @param \Closure $closure
     *
     * @return void
     * @see \SprykerTest\Shared\Testify\Helper\DataCleanupHelper::addCleanup()
     */
    public function addCleanup(\Closure $closure): void {
        $this->getScenario()->runStep(new \Codeception\Step\Action('addCleanup', func_get_args()));
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
     * @param int $code
     *
     * @return void
     * @see \SprykerProjectTest\Glue\Testify\Helper\GlueBackendApiHelper::seeResponseCodeIs()
     */
    public function seeResponseCodeIs(int $code): void {
        $this->getScenario()->runStep(new \Codeception\Step\Assertion('seeResponseCodeIs', func_get_args()));
    }
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * [!] Conditional Assertion: Test won't be stopped on fail
     * @param int $code
     *
     * @return void
     * @see \SprykerProjectTest\Glue\Testify\Helper\GlueBackendApiHelper::seeResponseCodeIs()
     */
    public function canSeeResponseCodeIs(int $code): void {
        $this->getScenario()->runStep(new \Codeception\Step\ConditionalAssertion('seeResponseCodeIs', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     *
     * @see \SprykerProjectTest\Glue\Testify\Helper\GlueBackendApiHelper::seeResponseContainsErrorMessage()
     */
    public function seeResponseContainsErrorMessage(string $expectedErrorMessage): void {
        $this->getScenario()->runStep(new \Codeception\Step\Assertion('seeResponseContainsErrorMessage', func_get_args()));
    }
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * [!] Conditional Assertion: Test won't be stopped on fail
     *
     * @see \SprykerProjectTest\Glue\Testify\Helper\GlueBackendApiHelper::seeResponseContainsErrorMessage()
     */
    public function canSeeResponseContainsErrorMessage(string $expectedErrorMessage): void {
        $this->getScenario()->runStep(new \Codeception\Step\ConditionalAssertion('seeResponseContainsErrorMessage', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @param \Spryker\Glue\GlueJsonApiConventionExtension\Dependency\Plugin\JsonApiResourceInterface $jsonApiResourcePlugin
     *
     * @return void
     * @see \SprykerTest\Glue\Testify\Helper\GlueBackendApiHelper::addJsonApiResourcePlugin()
     */
    public function addJsonApiResourcePlugin(\Spryker\Glue\GlueJsonApiConventionExtension\Dependency\Plugin\JsonApiResourceInterface $jsonApiResourcePlugin): void {
        $this->getScenario()->runStep(new \Codeception\Step\Action('addJsonApiResourcePlugin', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * Add another header to the default defined headers.
     *
     * @param string $headerName
     * @param string|int $headerValue
     *
     * @return void
     * @see \SprykerTest\Glue\Testify\Helper\GlueBackendApiHelper::addHeader()
     */
    public function addHeader(string $headerName, string|int $headerValue): void {
        $this->getScenario()->runStep(new \Codeception\Step\Action('addHeader', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * Use this method to override ALL default and previously set headers.
     *
     * @param array<string, string|int> $headers
     *
     * @return void
     * @see \SprykerTest\Glue\Testify\Helper\GlueBackendApiHelper::setHeaders()
     */
    public function setHeaders(array $headers): void {
        $this->getScenario()->runStep(new \Codeception\Step\Action('setHeaders', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @param string $url
     * @param array<mixed, mixed> $parameters
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @see \SprykerTest\Glue\Testify\Helper\GlueBackendApiHelper::sendGet()
     */
    public function sendGet(string $url, array $parameters = []): \Symfony\Component\HttpFoundation\Response {
        return $this->getScenario()->runStep(new \Codeception\Step\Action('sendGet', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @param string $url
     * @param array<mixed, mixed> $parameters
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @see \SprykerTest\Glue\Testify\Helper\GlueBackendApiHelper::sendPost()
     */
    public function sendPost(string $url, array $parameters = []): \Symfony\Component\HttpFoundation\Response {
        return $this->getScenario()->runStep(new \Codeception\Step\Action('sendPost', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @param string $url
     * @param array<mixed, mixed> $parameters
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @see \SprykerTest\Glue\Testify\Helper\GlueBackendApiHelper::sendPatch()
     */
    public function sendPatch(string $url, array $parameters = []): \Symfony\Component\HttpFoundation\Response {
        return $this->getScenario()->runStep(new \Codeception\Step\Action('sendPatch', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @param string $url
     * @param array<mixed, mixed> $parameters
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @see \SprykerTest\Glue\Testify\Helper\GlueBackendApiHelper::sendDelete()
     */
    public function sendDelete(string $url, array $parameters = []): \Symfony\Component\HttpFoundation\Response {
        return $this->getScenario()->runStep(new \Codeception\Step\Action('sendDelete', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @return void
     * @see \SprykerTest\Glue\Testify\Helper\GlueBackendApiHelper::seeResponseIsJson()
     */
    public function seeResponseIsJson(): void {
        $this->getScenario()->runStep(new \Codeception\Step\Assertion('seeResponseIsJson', func_get_args()));
    }
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * [!] Conditional Assertion: Test won't be stopped on fail
     * @return void
     * @see \SprykerTest\Glue\Testify\Helper\GlueBackendApiHelper::seeResponseIsJson()
     */
    public function canSeeResponseIsJson(): void {
        $this->getScenario()->runStep(new \Codeception\Step\ConditionalAssertion('seeResponseIsJson', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @return \SprykerTest\Glue\Testify\Helper\Connection|null
     * @see \SprykerTest\Glue\Testify\Helper\GlueBackendApiHelper::getLastConnection()
     */
    public function getLastConnection(): ?\SprykerTest\Glue\Testify\Helper\Connection {
        return $this->getScenario()->runStep(new \Codeception\Step\Action('getLastConnection', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @param string $jsonPath
     *
     * @return void
     * @see \SprykerTest\Glue\Testify\Helper\JsonPath::seeResponseMatchesJsonPath()
     */
    public function seeResponseMatchesJsonPath(string $jsonPath): void {
        $this->getScenario()->runStep(new \Codeception\Step\Assertion('seeResponseMatchesJsonPath', func_get_args()));
    }
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * [!] Conditional Assertion: Test won't be stopped on fail
     * @param string $jsonPath
     *
     * @return void
     * @see \SprykerTest\Glue\Testify\Helper\JsonPath::seeResponseMatchesJsonPath()
     */
    public function canSeeResponseMatchesJsonPath(string $jsonPath): void {
        $this->getScenario()->runStep(new \Codeception\Step\ConditionalAssertion('seeResponseMatchesJsonPath', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @param string $jsonPath
     *
     * @return void
     * @see \SprykerTest\Glue\Testify\Helper\JsonPath::dontSeeResponseMatchesJsonPath()
     */
    public function dontSeeResponseMatchesJsonPath(string $jsonPath): void {
        $this->getScenario()->runStep(new \Codeception\Step\Action('dontSeeResponseMatchesJsonPath', func_get_args()));
    }
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * [!] Conditional Assertion: Test won't be stopped on fail
     * @param string $jsonPath
     *
     * @return void
     * @see \SprykerTest\Glue\Testify\Helper\JsonPath::dontSeeResponseMatchesJsonPath()
     */
    public function cantSeeResponseMatchesJsonPath(string $jsonPath): void {
        $this->getScenario()->runStep(new \Codeception\Step\ConditionalAssertion('dontSeeResponseMatchesJsonPath', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @param array $jsonType
     * @param string $jsonPath
     *
     * @return void
     * @see \SprykerTest\Glue\Testify\Helper\JsonPath::seeResponseJsonPathMatchesJsonType()
     */
    public function seeResponseJsonPathMatchesJsonType(array $jsonType, string $jsonPath = "$"): void {
        $this->getScenario()->runStep(new \Codeception\Step\Assertion('seeResponseJsonPathMatchesJsonType', func_get_args()));
    }
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * [!] Conditional Assertion: Test won't be stopped on fail
     * @param array $jsonType
     * @param string $jsonPath
     *
     * @return void
     * @see \SprykerTest\Glue\Testify\Helper\JsonPath::seeResponseJsonPathMatchesJsonType()
     */
    public function canSeeResponseJsonPathMatchesJsonType(array $jsonType, string $jsonPath = "$"): void {
        $this->getScenario()->runStep(new \Codeception\Step\ConditionalAssertion('seeResponseJsonPathMatchesJsonType', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @param array $subArray
     * @param string $jsonPath
     *
     * @return void
     * @see \SprykerTest\Glue\Testify\Helper\JsonPath::seeResponseJsonPathContains()
     */
    public function seeResponseJsonPathContains(array $subArray, string $jsonPath = "$"): void {
        $this->getScenario()->runStep(new \Codeception\Step\Assertion('seeResponseJsonPathContains', func_get_args()));
    }
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * [!] Conditional Assertion: Test won't be stopped on fail
     * @param array $subArray
     * @param string $jsonPath
     *
     * @return void
     * @see \SprykerTest\Glue\Testify\Helper\JsonPath::seeResponseJsonPathContains()
     */
    public function canSeeResponseJsonPathContains(array $subArray, string $jsonPath = "$"): void {
        $this->getScenario()->runStep(new \Codeception\Step\ConditionalAssertion('seeResponseJsonPathContains', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @param string $className
     *
     * @throws \Codeception\Exception\ModuleException
     *
     * @return \Codeception\Module
     * @see \SprykerTest\Glue\Testify\Helper\JsonPath::locateModule()
     */
    public function locateModule(string $className): \Codeception\Module {
        return $this->getScenario()->runStep(new \Codeception\Step\Action('locateModule', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @param string $className
     *
     * @return \Codeception\Module|null
     * @see \SprykerTest\Glue\Testify\Helper\JsonPath::findModule()
     */
    public function findModule(string $className): ?\Codeception\Module {
        return $this->getScenario()->runStep(new \Codeception\Step\Action('findModule', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * Asserts that an array has a specified subset.
     *
     * @param array|ArrayAccess|mixed[] $subset
     * @param array|ArrayAccess|mixed[] $array
     *
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException|Exception
     * @throws Exception
     * @see \SprykerTest\Glue\Testify\Helper\JsonPath::assertArraySubset()
     */
    public function assertArraySubset($subset, $array, bool $checkForObjectIdentity = false, string $message = ""): void {
        $this->getScenario()->runStep(new \Codeception\Step\Action('assertArraySubset', func_get_args()));
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
     * Setup the MessageBroker to use the InMemory Transport for a specific message and the channel name the message will use.
     *
     * @param string $messageClassName The transfer class name
     * @param string $channelName The channel name we will use for processing
     *
     * @return void
     * @see \SprykerTest\Zed\MessageBroker\Helper\InMemoryMessageBrokerHelper::setupMessageBroker()
     */
    public function setupMessageBroker(string $messageClassName, string $channelName): void {
        $this->getScenario()->runStep(new \Codeception\Step\Action('setupMessageBroker', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @param string $messageName
     *
     * @return void
     * @see \SprykerTest\Zed\MessageBroker\Helper\InMemoryMessageBrokerHelper::assertMessageWasSent()
     */
    public function assertMessageWasSent(string $messageName): void {
        $this->getScenario()->runStep(new \Codeception\Step\Action('assertMessageWasSent', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @param string $messageName
     * @param array $requiredHeader
     *
     * @return void
     * @see \SprykerTest\Zed\MessageBroker\Helper\InMemoryMessageBrokerHelper::assertMessageWasSentWithRequiredHeader()
     */
    public function assertMessageWasSentWithRequiredHeader(string $messageName, array $requiredHeader): void {
        $this->getScenario()->runStep(new \Codeception\Step\Action('assertMessageWasSentWithRequiredHeader', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @deprecated Use {@link \Spryker\Zed\TestifyAsyncApi\Business\Codeception\Helper\AsyncApiHelper::assertMessageWasEmittedOnChannel()} instead.
     *
     * @param \Spryker\Shared\Kernel\Transfer\AbstractTransfer $expectedMessageTransfer
     * @param array<string, string|int|array<string, string|int>> $requiredFields
     *
     * @return void
     * @see \SprykerTest\Zed\MessageBroker\Helper\InMemoryMessageBrokerHelper::assertMessageWasSentWithRequiredFields()
     */
    public function assertMessageWasSentWithRequiredFields(\Spryker\Shared\Kernel\Transfer\AbstractTransfer $expectedMessageTransfer, array $requiredFields): void {
        $this->getScenario()->runStep(new \Codeception\Step\Action('assertMessageWasSentWithRequiredFields', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @param string $messageName
     *
     * @return \Spryker\Shared\Kernel\Transfer\AbstractTransfer
     * @see \SprykerTest\Zed\MessageBroker\Helper\InMemoryMessageBrokerHelper::getMessageTransferByMessageName()
     */
    public function getMessageTransferByMessageName(string $messageName): \Spryker\Shared\Kernel\Transfer\AbstractTransfer {
        return $this->getScenario()->runStep(new \Codeception\Step\Action('getMessageTransferByMessageName', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @param string $messageName
     *
     * @return void
     * @see \SprykerTest\Zed\MessageBroker\Helper\InMemoryMessageBrokerHelper::assertMessageWasNotSent()
     */
    public function assertMessageWasNotSent(string $messageName): void {
        $this->getScenario()->runStep(new \Codeception\Step\Action('assertMessageWasNotSent', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @param callable $callback
     * @param string $messageName
     *
     * @return void
     * @see \SprykerTest\Zed\MessageBroker\Helper\InMemoryMessageBrokerHelper::assertMessagesByCallbackForMessageName()
     */
    public function assertMessagesByCallbackForMessageName(callable $callback, string $messageName): void {
        $this->getScenario()->runStep(new \Codeception\Step\Action('assertMessagesByCallbackForMessageName', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @return void
     * @see \SprykerTest\Zed\MessageBroker\Helper\InMemoryMessageBrokerHelper::resetInMemoryMessages()
     */
    public function resetInMemoryMessages(): void {
        $this->getScenario()->runStep(new \Codeception\Step\Action('resetInMemoryMessages', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @param array<\Spryker\Zed\MessageBrokerExtension\Dependency\Plugin\MessageHandlerPluginInterface> $messageHandlerPlugins
     *
     * @return void
     * @see \SprykerTest\Zed\MessageBroker\Helper\InMemoryMessageBrokerHelper::setMessageHandlerPlugins()
     */
    public function setMessageHandlerPlugins(array $messageHandlerPlugins): void {
        $this->getScenario()->runStep(new \Codeception\Step\Action('setMessageHandlerPlugins', func_get_args()));
    }

 
    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *
     * @return void
     * @see \SprykerTest\Zed\Testify\Helper\AbstractDependencyProviderHelper::cleanUp()
     */
    public function cleanUp(): void {
        $this->getScenario()->runStep(new \Codeception\Step\Action('cleanUp', func_get_args()));
    }
}