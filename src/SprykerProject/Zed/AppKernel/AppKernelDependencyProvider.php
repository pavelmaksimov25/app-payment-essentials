<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace AppPayment\Zed\AppKernel;

use AppPayment\Zed\Payment\Communication\Plugin\AppKernel\SendPaymentMethodAddedMessageConfigurationAfterSavePlugin;
use AppPayment\Zed\Payment\Communication\Plugin\AppKernel\SendPaymentMethodDeletedMessageConfigurationAfterDeletePlugin;
use Spryker\Zed\AppKernel\AppKernelDependencyProvider as SprykerAppKernelDependencyProvider;
use Spryker\Zed\AppKernelExtension\Dependency\Plugin\ConfigurationAfterDeletePluginInterface;
use Spryker\Zed\AppKernelExtension\Dependency\Plugin\ConfigurationAfterSavePluginInterface;

class AppKernelDependencyProvider extends SprykerAppKernelDependencyProvider
{
    protected function getConfigurationAfterSavePlugin(): ?ConfigurationAfterSavePluginInterface
    {
        return new SendPaymentMethodAddedMessageConfigurationAfterSavePlugin();
    }

    protected function getConfigurationAfterDeletePlugin(): ?ConfigurationAfterDeletePluginInterface
    {
        return new SendPaymentMethodDeletedMessageConfigurationAfterDeletePlugin();
    }
}
