<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerProject\Zed\Payment\Communication\Plugin\AppKernel;

use Generated\Shared\Transfer\AppConfigTransfer;
use Spryker\Zed\AppKernelExtension\Dependency\Plugin\ConfigurationAfterSavePluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \SprykerProject\Zed\Payment\PaymentConfig getConfig()
 * @method \SprykerProject\Zed\Payment\Business\PaymentFacadeInterface getFacade()
 * @method \SprykerProject\Zed\Payment\Business\PaymentBusinessFactory getFactory()
 */
class SendPaymentMethodAddedMessageConfigurationAfterSavePlugin extends AbstractPlugin implements ConfigurationAfterSavePluginInterface
{
    public function afterSave(AppConfigTransfer $appConfigTransfer): AppConfigTransfer
    {
        return $this->getFacade()->sendPaymentMethodAddedMessage($appConfigTransfer);
    }
}
