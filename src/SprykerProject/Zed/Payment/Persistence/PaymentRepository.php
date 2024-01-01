<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerProject\Zed\Payment\Persistence;

use Generated\Shared\Transfer\PaymentTransfer;
use Orm\Zed\Payment\Persistence\SpyPayment;
use SprykerProject\Zed\Payment\Persistence\Exception\PaymentByTenantIdentifierAndOrderReferenceNotFoundException;
use SprykerProject\Zed\Payment\Persistence\Exception\PaymentByTransactionIdNotFoundException;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \SprykerProject\Zed\Payment\Persistence\PaymentPersistenceFactory getFactory()
 */
class PaymentRepository extends AbstractRepository implements PaymentRepositoryInterface
{
    /**
     * @throws \SprykerProject\Zed\Payment\Persistence\Exception\PaymentByTransactionIdNotFoundException
     */
    public function getByTransactionId(string $transactionId): PaymentTransfer
    {
        $spyPayment = $this->getFactory()->createPaymentQuery()->findOneByTransactionId($transactionId);

        if ($spyPayment === null) {
            throw new PaymentByTransactionIdNotFoundException($transactionId);
        }

        return $this->mapPaymentEntityToPaymentTransfer($spyPayment);
    }

    /**
     * @throws \SprykerProject\Zed\Payment\Persistence\Exception\PaymentByTenantIdentifierAndOrderReferenceNotFoundException
     */
    public function getByTenantIdentifierAndOrderReference(string $tenantIdentifier, string $orderReference): PaymentTransfer
    {
        $spyPayment = $this->getFactory()->createPaymentQuery()->filterByTenantIdentifier($tenantIdentifier)
            ->filterByOrderReference($orderReference)
            ->findOne();

        if ($spyPayment === null) {
            throw new PaymentByTenantIdentifierAndOrderReferenceNotFoundException($tenantIdentifier, $orderReference);
        }

        return $this->mapPaymentEntityToPaymentTransfer($spyPayment);
    }

    protected function mapPaymentEntityToPaymentTransfer(SpyPayment $spyPayment): PaymentTransfer
    {
        return $this->getFactory()->createPaymentMapper()->mapPaymentEntityToPaymentTransfer($spyPayment, new PaymentTransfer());
    }
}
