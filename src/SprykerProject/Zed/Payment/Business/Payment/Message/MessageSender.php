<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace AppPayment\Zed\Payment\Business\Payment\Message;

use ArrayObject;
use Generated\Shared\Transfer\AppConfigTransfer;
use Generated\Shared\Transfer\AppDisconnectTransfer;
use Generated\Shared\Transfer\MessageAttributesTransfer;
use Generated\Shared\Transfer\PaymentConfirmationFailedTransfer;
use Generated\Shared\Transfer\PaymentConfirmedTransfer;
use Generated\Shared\Transfer\PaymentMethodAddedTransfer;
use Generated\Shared\Transfer\PaymentMethodDeletedTransfer;
use Generated\Shared\Transfer\PaymentPreauthorizedTransfer;
use Generated\Shared\Transfer\PaymentTransfer;
use Generated\Shared\Transfer\QuoteItemTransfer;
use AppPayment\Zed\Payment\PaymentConfig;
use Spryker\Shared\Kernel\Transfer\TransferInterface;
use Spryker\Zed\AppKernel\AppKernelConfig;
use Spryker\Zed\AppKernel\Business\AppKernelFacadeInterface;
use Spryker\Zed\MessageBroker\Business\MessageBrokerFacadeInterface;

class MessageSender
{
    public function __construct(
        protected MessageBrokerFacadeInterface $messageBrokerFacade,
        protected PaymentConfig $paymentConfig,
        protected AppKernelFacadeInterface $appKernelFacade
    ) {
    }

    public function sendPaymentMethodAddedMessage(AppConfigTransfer $appConfigTransfer): AppConfigTransfer
    {
        // Only send the message when the AppConfig is in state NEW.
        if ($appConfigTransfer->getStatus() === AppKernelConfig::APP_STATUS_CONNECTED) {
            return $appConfigTransfer;
        }

        $paymentMethodAddedTransfer = new PaymentMethodAddedTransfer();
        $paymentMethodAddedTransfer
            ->setName($this->paymentConfig->getPaymentProviderName())
            ->setPaymentAuthorizationEndpoint(sprintf('%s/private/initialize-payment', $this->paymentConfig->getGlueBaseUrl()))
            ->setProviderName($this->paymentConfig->getPaymentProviderName());

        $paymentMethodAddedTransfer->setMessageAttributes($this->getMessageAttributes(
            $appConfigTransfer->getTenantIdentifierOrFail(),
            $paymentMethodAddedTransfer::class,
        ));

        $this->messageBrokerFacade->sendMessage($paymentMethodAddedTransfer);

        $appConfigTransfer->setStatus(AppKernelConfig::APP_STATUS_CONNECTED);

        $this->appKernelFacade->saveConfig($appConfigTransfer);

        return $appConfigTransfer;
    }

    public function sendPaymentMethodDeletedMessage(AppDisconnectTransfer $appDisconnectTransfer): AppDisconnectTransfer
    {
        $paymentMethodDeletedTransfer = new PaymentMethodDeletedTransfer();
        $paymentMethodDeletedTransfer
            ->setName($this->paymentConfig->getPaymentProviderName())
            ->setPaymentAuthorizationEndpoint(sprintf('%s/private/initialize-payment', $this->paymentConfig->getGlueBaseUrl()))
            ->setProviderName($this->paymentConfig->getPaymentProviderName());

        $paymentMethodDeletedTransfer->setMessageAttributes($this->getMessageAttributes(
            $appDisconnectTransfer->getTenantIdentifierOrFail(),
            $paymentMethodDeletedTransfer::class,
        ));

        $this->messageBrokerFacade->sendMessage($paymentMethodDeletedTransfer);

        return $appDisconnectTransfer;
    }

    public function sendPaymentConfirmedMessage(PaymentTransfer $paymentTransfer): void
    {
        $paymentConfirmedTransfer = $this->mapPaymentTransferToPaymentMessageTransfer($paymentTransfer, new PaymentConfirmedTransfer());

        $paymentConfirmedTransfer->setMessageAttributes($this->getMessageAttributes(
            $paymentTransfer->getTenantIdentifierOrFail(),
            $paymentConfirmedTransfer::class,
        ));

        $this->messageBrokerFacade->sendMessage($paymentConfirmedTransfer);
    }

    public function sendPaymentConfirmationFailedMessage(PaymentTransfer $paymentTransfer): void
    {
        $paymentConfirmationFailedTransfer = $this->mapPaymentTransferToPaymentMessageTransfer($paymentTransfer, new PaymentConfirmationFailedTransfer());

        $paymentConfirmationFailedTransfer->setMessageAttributes($this->getMessageAttributes(
            $paymentTransfer->getTenantIdentifierOrFail(),
            $paymentConfirmationFailedTransfer::class,
        ));

        $this->messageBrokerFacade->sendMessage($paymentConfirmationFailedTransfer);
    }

    public function sendPaymentPreauthorizedMessage(PaymentTransfer $paymentTransfer): void
    {
        $paymentPreauthorizedTransfer = $this->mapPaymentTransferToPaymentMessageTransfer($paymentTransfer, new PaymentPreauthorizedTransfer());

        $paymentPreauthorizedTransfer->setMessageAttributes($this->getMessageAttributes(
            $paymentTransfer->getTenantIdentifierOrFail(),
            $paymentPreauthorizedTransfer::class,
        ));

        $this->messageBrokerFacade->sendMessage($paymentPreauthorizedTransfer);
    }

    /**
     * @template T of \Spryker\Shared\Kernel\Transfer\TransferInterface
     *
     * @param T $transfer
     *
     * @return T
     */
    protected function mapPaymentTransferToPaymentMessageTransfer(
        PaymentTransfer $paymentTransfer,
        TransferInterface $transfer
    ): TransferInterface {
        $quoteTransfer = $paymentTransfer->getQuoteOrFail();

        $paymentData = [];
        $paymentData['orderReference'] = $paymentTransfer->getOrderReferenceOrFail();
        $paymentData['currencyIsoCode'] = $quoteTransfer->getCurrencyCodeOrFail();
        $paymentData['amount'] = $quoteTransfer->getGrandTotalOrFail();
        $paymentData['orderItemIds'] = $this->getOrderItemIds($paymentTransfer->getQuoteOrFail()->getItems());

        return $transfer->fromArray($paymentData, true);
    }

    /**
     * @param \ArrayObject<int, \Generated\Shared\Transfer\QuoteItemTransfer> $arrayObject
     *
     * @return array<int, mixed>
     */
    protected function getOrderItemIds(ArrayObject $arrayObject): array
    {
        return array_map(static function (QuoteItemTransfer $quoteItemTransfer): ?string {
            return $quoteItemTransfer->getIdSalesOrderItem();
        }, $arrayObject->getArrayCopy());
    }

    protected function getMessageAttributes(string $tenantIdentifier, string $transferName): MessageAttributesTransfer
    {
        $messageAttributesTransfer = new MessageAttributesTransfer();
        $messageAttributesTransfer
            ->setActorId($this->paymentConfig->getAppIdentifier())
            ->setEmitter($this->paymentConfig->getAppIdentifier())
            ->setTenantIdentifier($tenantIdentifier)
            ->setStoreReference($tenantIdentifier)
            ->setTransferName($transferName);

        return $messageAttributesTransfer;
    }
}
