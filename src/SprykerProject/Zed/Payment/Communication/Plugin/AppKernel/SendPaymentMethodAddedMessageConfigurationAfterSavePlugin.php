<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace AppPayment\Zed\Payment\Communication\Plugin\AppKernel;

use Generated\Shared\Transfer\AppConfigTransfer;
use Spryker\Zed\AppKernelExtension\Dependency\Plugin\ConfigurationAfterSavePluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \AppPayment\Zed\Payment\PaymentConfig getConfig()
 * @method \AppPayment\Zed\Payment\Business\PaymentFacadeInterface getFacade()
 * @method \AppPayment\Zed\Payment\Business\PaymentBusinessFactory getFactory()
 */
class SendPaymentMethodAddedMessageConfigurationAfterSavePlugin extends AbstractPlugin implements ConfigurationAfterSavePluginInterface
{
    public function afterSave(AppConfigTransfer $appConfigTransfer): AppConfigTransfer
    {
        return $this->getFacade()->sendPaymentMethodAddedMessage($appConfigTransfer);
    }
}
