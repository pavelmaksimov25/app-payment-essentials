<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerProjectTest\AsyncApi\Payment\PaymentTests\PaymentMethodCommands;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\AppDisconnectTransfer;
use SprykerProjectTest\AsyncApi\Payment\PaymentAsyncApiTester;
use Ramsey\Uuid\Uuid;
use Spryker\Zed\AppKernel\Business\AppKernelFacade;

/**
 * Auto-generated group annotations
 *
 * @group SprykerProjectTest
 * @group AsyncApi
 * @group Payment
 * @group PaymentTests
 * @group PaymentMethodCommands
 * @group PaymentMethodDeletedTest
 * Add your own group annotations below this line
 */
class PaymentMethodDeletedTest extends Unit
{
    protected PaymentAsyncApiTester $tester;

    public function testPaymentMethodDeletedMessageIsSend(): void
    {
        // Arrange
        $paymentMethodDeletedTransfer = $this->tester->havePaymentMethodDeletedTransfer();

        $tenantIdentifier = Uuid::uuid4()->toString();
        $this->tester->haveAppConfigForTenant($tenantIdentifier);

        $appDisconnectTransfer = new AppDisconnectTransfer();
        $appDisconnectTransfer->setTenantIdentifier($tenantIdentifier);

        $appKernelFacade = new AppKernelFacade();
        $appKernelFacade->deleteConfig($appDisconnectTransfer);

        // Assert
        $this->tester->assertMessageWasEmittedOnChannel($paymentMethodDeletedTransfer, 'payment-method-commands');
        $this->tester->assertAppConfigurationForTenantDoesNotExist($tenantIdentifier);
    }
}
