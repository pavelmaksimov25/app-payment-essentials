<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace AppPayment\Zed\Payment\Business\Payment\Capture;

use Generated\Shared\Transfer\CapturePaymentRequestTransfer;
use Generated\Shared\Transfer\CapturePaymentResponseTransfer;
use Generated\Shared\Transfer\PaymentTransfer;
use AppPayment\Zed\Payment\Business\Payment\AppConfig\AppConfigLoader;
use AppPayment\Zed\Payment\Business\Payment\Status\PaymentStatusEnum;
use AppPayment\Zed\Payment\Dependency\Plugin\PlatformPluginInterface;
use AppPayment\Zed\Payment\PaymentConfig;
use AppPayment\Zed\Payment\Persistence\PaymentEntityManagerInterface;
use Spryker\Shared\Log\LoggerTrait;
use Spryker\Zed\Kernel\Persistence\EntityManager\TransactionTrait;
use Throwable;

class PaymentCapturer
{
    use TransactionTrait;
    use LoggerTrait;

    public function __construct(
        protected PlatformPluginInterface $platformPlugin,
        protected PaymentEntityManagerInterface $paymentEntityManager,
        protected PaymentConfig $paymentConfig,
        protected AppConfigLoader $appConfigLoader
    ) {
    }

    public function capturePayment(CapturePaymentRequestTransfer $capturePaymentRequestTransfer): CapturePaymentResponseTransfer
    {
        try {
            $capturePaymentRequestTransfer->setAppConfigOrFail($this->appConfigLoader->loadAppConfig($capturePaymentRequestTransfer->getPaymentOrFail()->getTenantIdentifierOrFail()));
            $capturePaymentResponseTransfer = $this->platformPlugin->capturePayment($capturePaymentRequestTransfer);
        } catch (Throwable $throwable) {
            $this->getLogger()->error($throwable->getMessage());
            $capturePaymentResponseTransfer = new CapturePaymentResponseTransfer();
            $capturePaymentResponseTransfer
                ->setIsSuccessful(false)
                ->setMessage($throwable->getMessage());

            return $capturePaymentResponseTransfer;
        }

        /** @phpstan-var \Generated\Shared\Transfer\CapturePaymentResponseTransfer */
        return $this->getTransactionHandler()->handleTransaction(function () use ($capturePaymentRequestTransfer, $capturePaymentResponseTransfer) {
            if ($capturePaymentResponseTransfer->getIsSuccessful() === true) {
                $this->savePayment($capturePaymentRequestTransfer->getPaymentOrFail());
            }

            return $capturePaymentResponseTransfer;
        });
    }

    protected function savePayment(PaymentTransfer $paymentTransfer): void
    {
        $paymentTransfer->setStatus(PaymentStatusEnum::STATUS_CAPTURE_REQUESTED);
        $this->paymentEntityManager->savePayment($paymentTransfer);
    }
}
