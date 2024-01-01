<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerProject\Zed\Payment\Persistence;

use Generated\Shared\Transfer\PaymentTransfer;

interface PaymentRepositoryInterface
{
    /**
     * @throws \SprykerProject\Zed\Payment\Persistence\Exception\PaymentByTransactionIdNotFoundException
     */
    public function getByTransactionId(string $transactionId): PaymentTransfer;

    /**
     * @throws \SprykerProject\Zed\Payment\Persistence\Exception\PaymentByTenantIdentifierAndOrderReferenceNotFoundException
     */
    public function getByTenantIdentifierAndOrderReference(string $tenantIdentifier, string $orderReference): PaymentTransfer;
}
