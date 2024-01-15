<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace AppPaymentTest\AsyncApi\Payment\PaymentTests\PaymentMethodCommands;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\AppConfigTransfer;
use Generated\Shared\Transfer\PaymentMethodAddedTransfer;
use AppPaymentTest\AsyncApi\Payment\PaymentAsyncApiTester;
use Ramsey\Uuid\Uuid;
use Spryker\Zed\AppKernel\AppKernelConfig;
use Spryker\Zed\AppKernel\Business\AppKernelFacade;

/**
 * Auto-generated group annotations
 *
 * @group AppPaymentTest
 * @group AsyncApi
 * @group Payment
 * @group PaymentTests
 * @group PaymentMethodCommands
 * @group PaymentMethodAddedTest
 * Add your own group annotations below this line
 */
class PaymentMethodAddedTest extends Unit
{
    protected PaymentAsyncApiTester $tester;

    public function testPaymentMethodAddedMessageIsSendWhenAppConfigStateIsNew(): void
    {
        // Arrange
        $paymentMethodAddedTransfer = $this->tester->havePaymentMethodAddedTransfer();

        $appConfigTransfer = new AppConfigTransfer();
        $appConfigTransfer
            ->setConfig(['my' => 'app', 'configuration' => 'data'])
            ->setTenantIdentifier(Uuid::uuid4()->toString())
            ->setIsActive(true)
            ->setStatus(AppKernelConfig::APP_STATUS_NEW);

        $appKernelFacade = new AppKernelFacade();
        $appKernelFacade->saveConfig($appConfigTransfer);

        // Assert
        $this->tester->assertMessageWasEmittedOnChannel($paymentMethodAddedTransfer, 'payment-method-commands');
    }

    public function testPaymentMethodAddedMessageIsNotSendWhenAppConfigStateIsConnected(): void
    {
        // Arrange
        $appConfigTransfer = new AppConfigTransfer();
        $appConfigTransfer
            ->setConfig(['my' => 'app', 'configuration' => 'data'])
            ->setTenantIdentifier(Uuid::uuid4()->toString())
            ->setIsActive(true)
            ->setStatus(AppKernelConfig::APP_STATUS_CONNECTED);

        $appKernelFacade = new AppKernelFacade();
        $appKernelFacade->saveConfig($appConfigTransfer);

        // Assert
        $this->tester->assertMessageWasNotSent(PaymentMethodAddedTransfer::class);
    }
}
