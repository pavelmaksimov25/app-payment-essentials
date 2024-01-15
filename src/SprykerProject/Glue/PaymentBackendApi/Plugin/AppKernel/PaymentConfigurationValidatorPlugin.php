<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace AppPayment\Glue\PaymentBackendApi\Plugin\AppKernel;

use Generated\Shared\Transfer\GlueRequestTransfer;
use Generated\Shared\Transfer\GlueRequestValidationTransfer;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\RequestValidatorPluginInterface;
use Spryker\Glue\Kernel\AbstractPlugin;

/**
 * @method \AppPayment\Glue\PaymentBackendApi\PaymentBackendApiFactory getFactory()
 */
class PaymentConfigurationValidatorPlugin extends AbstractPlugin implements RequestValidatorPluginInterface
{
    public function validate(GlueRequestTransfer $glueRequestTransfer): GlueRequestValidationTransfer
    {
        return $this->getFactory()->getPaymentFacade()->validatePaymentConfiguration($glueRequestTransfer);
    }
}
