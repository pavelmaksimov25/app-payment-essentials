<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerProject\Zed\Payment\Persistence;

use Orm\Zed\Payment\Persistence\SpyPaymentQuery;
use SprykerProject\Zed\Payment\Persistence\Propel\Payment\Mapper\PaymentMapper;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \SprykerProject\Zed\Payment\PaymentConfig getConfig()
 * @method \SprykerProject\Zed\Payment\Persistence\PaymentRepositoryInterface getRepository()
 * @method \SprykerProject\Zed\Payment\Persistence\PaymentEntityManagerInterface getEntityManager()
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
