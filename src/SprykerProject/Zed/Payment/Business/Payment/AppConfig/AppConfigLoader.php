<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerProject\Zed\Payment\Business\Payment\AppConfig;

use Generated\Shared\Transfer\AppConfigCriteriaTransfer;
use Generated\Shared\Transfer\AppConfigTransfer;
use Spryker\Zed\AppKernel\Business\AppKernelFacadeInterface;

class AppConfigLoader
{
    public function __construct(protected AppKernelFacadeInterface $appKernelFacade)
    {
    }

    public function loadAppConfig(string $tenantIdentifier): AppConfigTransfer
    {
        return $this->appKernelFacade->getConfig(
            (new AppConfigCriteriaTransfer())->setTenantIdentifier($tenantIdentifier),
            new AppConfigTransfer(),
        );
    }
}
