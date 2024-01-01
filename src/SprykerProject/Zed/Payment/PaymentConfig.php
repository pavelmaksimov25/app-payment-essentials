<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerProject\Zed\Payment;

use Spryker\Shared\AppKernel\AppKernelConstants;
use Spryker\Shared\Application\ApplicationConstants;
use Spryker\Shared\GlueJsonApiConvention\GlueJsonApiConventionConstants;
use Spryker\Zed\Kernel\AbstractBundleConfig;

class PaymentConfig extends AbstractBundleConfig
{
    /**
     * @var string
     */
    public const HEADER_TENANT_IDENTIFIER = 'x-tenant-identifier';

    public function getAppIdentifier(): string
    {
        return $this->getStringValue(AppKernelConstants::APP_IDENTIFIER);
    }

    public function getPaymentProviderName(): string
    {
        // When extracting into a standalone package we should throw an exception here when this method is not overriden on project level
        return 'Stripe';
    }

    public function getZedBaseUrl(): string
    {
        return $this->getStringValue(ApplicationConstants::BASE_URL_ZED);
    }

    public function getGlueBaseUrl(): string
    {
        return $this->getStringValue(GlueJsonApiConventionConstants::GLUE_DOMAIN);
    }

    protected function getStringValue(string $configKey): string
    {
        /** @phpstan-var string */
        return $this->get($configKey);
    }
}
