<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace AppPayment\Glue\AppKernel;

use AppPayment\Glue\PaymentBackendApi\Plugin\AppKernel\PaymentConfigurationValidatorPlugin;
use Spryker\Glue\AppKernel\AppKernelDependencyProvider as SprykerAppKernelDependencyProvider;

class AppKernelDependencyProvider extends SprykerAppKernelDependencyProvider
{
    protected function getRequestConfigureValidatorPlugins(): array
    {
        return [
            new PaymentConfigurationValidatorPlugin(),
        ];
    }
}
