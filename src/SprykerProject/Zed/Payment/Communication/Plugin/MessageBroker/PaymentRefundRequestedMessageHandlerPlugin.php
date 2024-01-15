<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace AppPayment\Zed\Payment\Communication\Plugin\MessageBroker;

use Generated\Shared\Transfer\PaymentRefundRequestedTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\MessageBrokerExtension\Dependency\Plugin\MessageHandlerPluginInterface;

/**
 * @method \AppPayment\Zed\Payment\Business\PaymentFacadeInterface getFacade()
 * @method \AppPayment\Zed\Payment\PaymentConfig getConfig()
 */
class PaymentRefundRequestedMessageHandlerPlugin extends AbstractPlugin implements MessageHandlerPluginInterface
{
    public function onPaymentRefundRequested(PaymentRefundRequestedTransfer $paymentRefundRequestedTransfer): void
    {
        $this->getFacade()->handlePaymentRefundRequested($paymentRefundRequestedTransfer);
    }

    /**
     * Return an array where the key is the class name to be handled and the value is the callable that handles the message.
     *
     * @return array<string, callable>
     */
    public function handles(): iterable
    {
        yield PaymentRefundRequestedTransfer::class => function (PaymentRefundRequestedTransfer $paymentRefundRequestedTransfer): void {
            $this->onPaymentRefundRequested($paymentRefundRequestedTransfer);
        };
    }
}
