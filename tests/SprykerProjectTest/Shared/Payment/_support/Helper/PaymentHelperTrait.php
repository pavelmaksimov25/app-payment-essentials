<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerProjectTest\Shared\Payment\Helper;

use Codeception\Module;

trait PaymentHelperTrait
{
    protected function getPaymentHelper(): PaymentHelper
    {
        /** @var \SprykerProjectTest\Shared\Payment\Helper\PaymentHelper $paymentHelper */
        $paymentHelper = $this->getModule('\\' . PaymentHelper::class);

        return $paymentHelper;
    }

    abstract protected function getModule(string $name): Module;
}
