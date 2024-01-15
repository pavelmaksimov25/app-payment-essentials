<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace AppPayment\Zed\Payment\Business\Payment\Initialize;

use Generated\Shared\Transfer\InitializePaymentRequestTransfer;
use Generated\Shared\Transfer\InitializePaymentResponseTransfer;
use Generated\Shared\Transfer\PaymentTransfer;
use AppPayment\Zed\Payment\Business\Payment\AppConfig\AppConfigLoader;
use AppPayment\Zed\Payment\Business\Payment\Status\PaymentStatusEnum;
use AppPayment\Zed\Payment\Dependency\Plugin\PlatformPluginInterface;
use AppPayment\Zed\Payment\PaymentConfig;
use AppPayment\Zed\Payment\Persistence\PaymentEntityManagerInterface;
use Spryker\Shared\Log\LoggerTrait;
use Spryker\Zed\Kernel\Persistence\EntityManager\TransactionTrait;
use Throwable;

class PaymentInitializer
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

    public function initializePayment(InitializePaymentRequestTransfer $initializePaymentRequestTransfer): InitializePaymentResponseTransfer
    {
        try {
            $initializePaymentRequestTransfer->setAppConfigOrFail($this->appConfigLoader->loadAppConfig($initializePaymentRequestTransfer->getTenantIdentifierOrFail()));
            $initializePaymentResponseTransfer = $this->platformPlugin->initializePayment($initializePaymentRequestTransfer);
        } catch (Throwable $throwable) {
            $this->getLogger()->error($throwable->getMessage());
            $initializePaymentResponseTransfer = new InitializePaymentResponseTransfer();
            $initializePaymentResponseTransfer
                ->setIsSuccessful(false)
                ->setMessage($throwable->getMessage());

            return $initializePaymentResponseTransfer;
        }

        $initializePaymentResponseTransfer = $this->addRedirectUrl($initializePaymentRequestTransfer, $initializePaymentResponseTransfer);

        /** @phpstan-var \Generated\Shared\Transfer\InitializePaymentResponseTransfer */
        return $this->getTransactionHandler()->handleTransaction(function () use ($initializePaymentRequestTransfer, $initializePaymentResponseTransfer) {
                $this->savePayment($initializePaymentRequestTransfer, $initializePaymentResponseTransfer);

                return $initializePaymentResponseTransfer;
        });
    }

    /**
     * Add the URL the end-user gets redirected to fill out the platform payment page.
     * This URL will be the same for all Payment Platforms.
     */
    protected function addRedirectUrl(
        InitializePaymentRequestTransfer $initializePaymentRequestTransfer,
        InitializePaymentResponseTransfer $initializePaymentResponseTransfer
    ): InitializePaymentResponseTransfer {
        $initializePaymentResponseTransfer->setRedirectUrl(
            sprintf(
                '%s/payment?%s=%s&%s=%s',
                $this->paymentConfig->getZedBaseUrl(),
                PaymentTransfer::TRANSACTION_ID,
                $initializePaymentResponseTransfer->getTransactionId(),
                PaymentTransfer::TENANT_IDENTIFIER,
                $initializePaymentRequestTransfer->getTenantIdentifier(),
            ),
        );

        return $initializePaymentResponseTransfer;
    }

    protected function savePayment(
        InitializePaymentRequestTransfer $initializePaymentRequestTransfer,
        InitializePaymentResponseTransfer $initializePaymentResponseTransfer
    ): void {
        $quoteTransfer = $initializePaymentRequestTransfer->getOrderDataOrFail();

        $paymentTransfer = new PaymentTransfer();
        $paymentTransfer
            ->setTransactionId($initializePaymentResponseTransfer->getTransactionIdOrFail())
            ->setTenantIdentifier($initializePaymentRequestTransfer->getTenantIdentifier())
            ->setOrderReference($quoteTransfer->getOrderReference())
            ->setQuote($quoteTransfer)
            ->setCheckoutSummaryPageUrl($initializePaymentRequestTransfer->getCheckoutSummaryPageUrl())
            ->setRedirectSuccessUrl($initializePaymentRequestTransfer->getRedirectSuccessUrl())
            ->setRedirectCancelUrl($initializePaymentRequestTransfer->getRedirectCancelUrl())
            ->setStatus(PaymentStatusEnum::STATUS_NEW);

        $this->paymentEntityManager->createPayment($paymentTransfer);
    }
}
