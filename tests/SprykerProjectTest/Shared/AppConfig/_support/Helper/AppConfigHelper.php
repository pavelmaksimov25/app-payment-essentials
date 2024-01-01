<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerProjectTest\Shared\AppConfig\Helper;

use Codeception\Module;
use Generated\Shared\Transfer\AppConfigCriteriaTransfer;
use Generated\Shared\Transfer\AppConfigTransfer;
use Orm\Zed\AppKernel\Persistence\SpyAppConfigQuery;
use Spryker\Zed\AppKernel\Business\AppKernelFacade;
use Spryker\Zed\AppKernel\Persistence\AppKernelEntityManager;

class AppConfigHelper extends Module
{
    /**
     * @param array|string $appConfiguration
     */
    public function haveAppConfigForTenant(string $tenantIdentifier, ?array $appConfiguration = null): AppConfigTransfer
    {
        $appConfigTransfer = new AppConfigTransfer();
        $appConfigTransfer->setTenantIdentifier($tenantIdentifier)
            ->setConfig($appConfiguration ?? $this->getDefaultConfigData());

        $appKernelEntityManager = new AppKernelEntityManager();
        $appKernelEntityManager->saveConfig($appConfigTransfer);

        return $appConfigTransfer;
    }

    /**
     * @param array|string $expectedAppConfig
     */
    public function assertAppConfigForTenantEquals(string $tenantIdentifier, ?array $expectedAppConfig = null): void
    {
        $appKernelFacade = new AppKernelFacade();
        $appConfigTransfer = $appKernelFacade->getConfig((new AppConfigCriteriaTransfer())->setTenantIdentifier($tenantIdentifier), new AppConfigTransfer());

        $this->assertNotNull($appConfigTransfer, sprintf('Expected to find a StripeConfiguration for the Tenant "%s" but haven\'t found one.', $tenantIdentifier));

        $expectedAppConfig = $expectedAppConfig ?? $this->getDefaultConfigData();

        $this->assertSame($expectedAppConfig, $appConfigTransfer->modifiedToArray(true, true)['config']);
    }

    public function assertAppConfigForTenantIsInState(string $tenantIdentifier, string $state): void
    {
        $appKernelFacade = new AppKernelFacade();
        $appConfigTransfer = $appKernelFacade->getConfig((new AppConfigCriteriaTransfer())->setTenantIdentifier($tenantIdentifier), new AppConfigTransfer());

        $this->assertNotNull($appConfigTransfer, sprintf('Expected to find a StripeConfiguration for the Tenant "%s" but haven\'t found one.', $tenantIdentifier));

        $this->assertSame($state, $appConfigTransfer->getStatus());
    }

    public function assertAppConfigurationForTenantDoesNotExist(string $tenantIdentifier): void
    {
        $spyAppConfigQuery = SpyAppConfigQuery::create();
        $tenantStripeConfigurationEntity = $spyAppConfigQuery->findOneByTenantIdentifier($tenantIdentifier);

        $this->assertNull($tenantStripeConfigurationEntity, sprintf('Expected not to find an AppConfiguration for the Tenant "%s" but found one.', $tenantIdentifier));
    }

    /**
     * @return array<array>
     */
    public function getAppConfigureRequestData(): array
    {
        return [
            'data' => [
                'type' => 'configuration',
                'attributes' => [
                    'configuration' => json_encode($this->getDefaultConfigData()),
                ],
            ],
        ];
    }

    protected function getDefaultConfigData(): array
    {
        return [
            'mode' => 'test',
            'accountId' => 'acct_xxxxxxxx',
            'paymentPageLabel' => 'paymentPageLabel',
        ];
    }
}
