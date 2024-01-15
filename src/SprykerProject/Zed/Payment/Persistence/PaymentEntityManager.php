<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace AppPayment\Zed\Payment\Persistence;

use Generated\Shared\Transfer\PaymentTransfer;
use Orm\Zed\Payment\Persistence\SpyPayment;
use AppPayment\Zed\Payment\Persistence\Exception\PaymentByTransactionIdNotFoundException;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;

/**
 * @method \AppPayment\Zed\Payment\Persistence\PaymentPersistenceFactory getFactory()
 */
class PaymentEntityManager extends AbstractEntityManager implements PaymentEntityManagerInterface
{
    public function createPayment(PaymentTransfer $paymentTransfer): PaymentTransfer
    {
        $spyPayment = $this->getFactory()->createPaymentMapper()->mapPaymentTransferToPaymentEntity($paymentTransfer, new SpyPayment());
        $spyPayment->save();

        return $this->getFactory()->createPaymentMapper()->mapPaymentEntityToPaymentTransfer($spyPayment, $paymentTransfer);
    }

    public function savePayment(PaymentTransfer $paymentTransfer): PaymentTransfer
    {
        $spyPayment = $this->getFactory()->createPaymentQuery()->findOneByTransactionId($paymentTransfer->getTransactionIdOrFail());

        if ($spyPayment === null) {
            throw new PaymentByTransactionIdNotFoundException($paymentTransfer->getTransactionIdOrFail());
        }

        $spyPayment = $this->getFactory()->createPaymentMapper()->mapPaymentTransferToPaymentEntity($paymentTransfer, $spyPayment);
        $spyPayment->save();

        return $this->getFactory()->createPaymentMapper()->mapPaymentEntityToPaymentTransfer($spyPayment, $paymentTransfer);
    }
}
