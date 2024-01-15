<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace AppPayment\Zed\Payment\Business\Payment\Webhook;

use Generated\Shared\Transfer\WebhookRequestTransfer;
use Generated\Shared\Transfer\WebhookResponseTransfer;
use InvalidArgumentException;
use AppPayment\Zed\Payment\Business\Message\MessageBuilder;
use AppPayment\Zed\Payment\Business\Payment\AppConfig\AppConfigLoader;
use AppPayment\Zed\Payment\Business\Payment\Status\PaymentStatusTransitionValidator;
use AppPayment\Zed\Payment\Dependency\Plugin\PlatformPluginInterface;
use AppPayment\Zed\Payment\Dependency\Plugin\PlatformPluginTransactionIdAwareInterface;
use AppPayment\Zed\Payment\Persistence\PaymentEntityManagerInterface;
use AppPayment\Zed\Payment\Persistence\PaymentRepositoryInterface;
use Spryker\Shared\Log\LoggerTrait;
use Spryker\Zed\Kernel\Persistence\EntityManager\TransactionTrait;
use Throwable;

class WebhookHandler
{
    use TransactionTrait;
    use LoggerTrait;

    public function __construct(
        protected PlatformPluginInterface $platformPlugin,
        protected AppConfigLoader $appConfigLoader,
        protected PaymentStatusTransitionValidator $paymentStatusTransitionValidator,
        protected PaymentRepositoryInterface $paymentRepository,
        protected PaymentEntityManagerInterface $paymentEntityManager,
        protected WebhookMessageSender $webhookMessageSender
    ) {
    }

    public function handleWebhook(WebhookRequestTransfer $webhookRequestTransfer): WebhookResponseTransfer
    {
        try {
            $transactionId = $this->getTransactionIdOrFail($webhookRequestTransfer);

            $paymentTransfer = $this->paymentRepository->getByTransactionId($transactionId);
            $appConfigTransfer = $this->appConfigLoader->loadAppConfig($paymentTransfer->getTenantIdentifierOrFail());

            $webhookRequestTransfer->setPaymentOrFail($paymentTransfer);
            $webhookRequestTransfer->setAppConfigOrFail($appConfigTransfer);

            $webhookResponseTransfer = $this->platformPlugin->handleWebhook($webhookRequestTransfer);
        } catch (Throwable $throwable) {
            $this->getLogger()->error($throwable->getMessage());
            $webhookResponseTransfer = new WebhookResponseTransfer();
            $webhookResponseTransfer
                ->setIsSuccessful(false)
                ->setMessage($throwable->getMessage());

            return $webhookResponseTransfer;
        }

        // Return a failed response when response transfer is not successful.
        // The message should already be set in the payment platform plugin.
        if ($webhookResponseTransfer->getIsSuccessful() !== true) {
            return $webhookResponseTransfer;
        }

        /** @phpstan-var \Generated\Shared\Transfer\WebhookResponseTransfer */
        return $this->getTransactionHandler()->handleTransaction(function () use ($webhookRequestTransfer, $webhookResponseTransfer) {
            $paymentTransfer = $webhookRequestTransfer->getPaymentOrFail();

            $targetStatus = $webhookResponseTransfer->getPaymentStatusOrFail();

            $sourceStatus = $paymentTransfer->getStatusOrFail();

            if ($sourceStatus === $targetStatus) {
                $this->getLogger()->info(MessageBuilder::paymentStatusAlreadyInStatus($targetStatus));

                return $webhookResponseTransfer->setIsSuccessful(true);
            }

            if (!$this->paymentStatusTransitionValidator->isTransitionAllowed($sourceStatus, $targetStatus)) {
                $webhookResponseTransfer
                    ->setIsSuccessful(false)
                    ->setMessage(MessageBuilder::paymentStatusTransitionNotAllowed($sourceStatus, $targetStatus));

                return $webhookResponseTransfer;
            }

            $paymentTransfer->setStatus($webhookResponseTransfer->getPaymentStatus());

            try {
                $this->paymentEntityManager->savePayment($paymentTransfer);
            } catch (Throwable $throwable) {
                $this->getLogger()->error($throwable->getMessage());
                $webhookResponseTransfer
                    ->setIsSuccessful(false)
                    ->setMessage($throwable->getMessage());

                return $webhookResponseTransfer;
            }

            $this->webhookMessageSender->determineAndSendMessage($webhookRequestTransfer);

            return $webhookResponseTransfer;
        });
    }

    private function getTransactionIdOrFail(WebhookRequestTransfer $webhookRequestTransfer): string
    {
        if ($webhookRequestTransfer->getTransactionId() !== null && $webhookRequestTransfer->getTransactionId() !== '') {
            return $webhookRequestTransfer->getTransactionId();
        }

        if ($this->platformPlugin instanceof PlatformPluginTransactionIdAwareInterface) {
            return $this->platformPlugin->getTransactionIdFromWebhookData($webhookRequestTransfer);
        }

        throw new InvalidArgumentException(MessageBuilder::getRequestTransactionIdIsMissingOrEmpty());
    }
}
