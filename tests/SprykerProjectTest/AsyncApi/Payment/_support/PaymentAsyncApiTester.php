<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace SprykerProjectTest\AsyncApi\Payment;

use Codeception\Actor;
use Codeception\Stub;
use Generated\Shared\Transfer\WebhookResponseTransfer;
use SprykerProject\Zed\Payment\Dependency\Plugin\PlatformPluginTransactionIdAwareInterface;
use SprykerProject\Zed\Payment\PaymentDependencyProvider;

/**
 * Inherited Methods
 *
 * @method void wantTo($text)
 * @method void wantToTest($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause($vars = [])
 *
 * @SuppressWarnings(\SprykerProjectTest\AsyncApi\Payment\PHPMD)
 */
class PaymentAsyncApiTester extends Actor
{
    use _generated\PaymentAsyncApiTesterActions;

    public function mockPlatformPlugin(string $transactionId, string $status): void
    {
        $platformPluginMock = Stub::makeEmpty(PlatformPluginTransactionIdAwareInterface::class, [
            'handleWebhook' => function () use ($status): WebhookResponseTransfer {
                $webhookResponseTransfer = new WebhookResponseTransfer();
                $webhookResponseTransfer->setIsSuccessful(true);
                $webhookResponseTransfer->setPaymentStatus($status);

                return $webhookResponseTransfer;
            },
            'getTransactionIdFromWebhookData' => function () use ($transactionId) {
                return $transactionId;
            },
        ]);

        $this->setDependency(PaymentDependencyProvider::PLUGIN_PLATFORM, $platformPluginMock);
    }
}
