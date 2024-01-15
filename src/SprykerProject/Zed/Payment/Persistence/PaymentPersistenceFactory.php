<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace AppPayment\Zed\Payment\Persistence;

use Orm\Zed\Payment\Persistence\SpyPaymentQuery;
use AppPayment\Zed\Payment\Persistence\Propel\Payment\Mapper\PaymentMapper;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \AppPayment\Zed\Payment\PaymentConfig getConfig()
 * @method \AppPayment\Zed\Payment\Persistence\PaymentRepositoryInterface getRepository()
 * @method \AppPayment\Zed\Payment\Persistence\PaymentEntityManagerInterface getEntityManager()
 */
class PaymentPersistenceFactory extends AbstractPersistenceFactory
{
    public function createPaymentQuery(): SpyPaymentQuery
    {
        return new SpyPaymentQuery();
    }

    public function createPaymentMapper(): PaymentMapper
    {
        return new PaymentMapper();
    }
}
