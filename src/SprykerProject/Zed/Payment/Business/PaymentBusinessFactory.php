<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace AppPayment\Zed\Payment\Business;

use AppPayment\Zed\Payment\Business\MessageBroker\PaymentCancelReservationRequestedMessageHandler;
use AppPayment\Zed\Payment\Business\MessageBroker\PaymentCancelReservationRequestedMessageHandlerInterface;
use AppPayment\Zed\Payment\Business\MessageBroker\PaymentConfirmationRequestedMessageHandler;
use AppPayment\Zed\Payment\Business\MessageBroker\PaymentConfirmationRequestedMessageHandlerInterface;
use AppPayment\Zed\Payment\Business\MessageBroker\PaymentRefundRequestedMessageHandler;
use AppPayment\Zed\Payment\Business\MessageBroker\PaymentRefundRequestedMessageHandlerInterface;
use AppPayment\Zed\Payment\Business\MessageBroker\TenantIdentifier\TenantIdentifierExtractor;
use AppPayment\Zed\Payment\Business\Payment\AppConfig\AppConfigLoader;
use AppPayment\Zed\Payment\Business\Payment\Capture\PaymentCapturer;
use AppPayment\Zed\Payment\Business\Payment\Initialize\PaymentInitializer;
use AppPayment\Zed\Payment\Business\Payment\Message\MessageSender;
use AppPayment\Zed\Payment\Business\Payment\Page\PaymentPage;
use AppPayment\Zed\Payment\Business\Payment\Payment;
use AppPayment\Zed\Payment\Business\Payment\Status\PaymentStatusTransitionValidator;
use AppPayment\Zed\Payment\Business\Payment\Validate\ConfigurationValidator;
use AppPayment\Zed\Payment\Business\Payment\Webhook\WebhookHandler;
use AppPayment\Zed\Payment\Business\Payment\Webhook\WebhookMessageSender;
use AppPayment\Zed\Payment\Dependency\Plugin\PlatformPluginInterface;
use AppPayment\Zed\Payment\PaymentDependencyProvider;
use Spryker\Service\UtilEncoding\UtilEncodingService;
use Spryker\Zed\AppKernel\Business\AppKernelFacade;
use Spryker\Zed\AppKernel\Business\AppKernelFacadeInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use Spryker\Zed\MessageBroker\Business\MessageBrokerFacade;

/**
 * @method \AppPayment\Zed\Payment\PaymentConfig getConfig()
 * @method \AppPayment\Zed\Payment\Persistence\PaymentEntityManagerInterface getEntityManager()
 * @method \AppPayment\Zed\Payment\Persistence\PaymentRepositoryInterface getRepository()
 */
class PaymentBusinessFactory extends AbstractBusinessFactory
{
    public function createPayment(): Payment
    {
        return new Payment(
            $this->getPlatformPlugin(),
            $this->createConfigurationValidator(),
            $this->createPaymentInitializer(),
            $this->createPaymentPage(),
            $this->createWebhookHandler(),
        );
    }

    public function createConfigurationValidator(): ConfigurationValidator
    {
        return new ConfigurationValidator($this->getPlatformPlugin(), new UtilEncodingService());
    }

    public function createPaymentInitializer(): PaymentInitializer
    {
        return new PaymentInitializer($this->getPlatformPlugin(), $this->getEntityManager(), $this->getConfig(), $this->createAppConfigLoader());
    }

    public function createPaymentPage(): PaymentPage
    {
        return new PaymentPage($this->getPlatformPlugin(), $this->getRepository(), $this->createAppConfigLoader());
    }

    public function createWebhookHandler(): WebhookHandler
    {
        return new WebhookHandler($this->getPlatformPlugin(), $this->createAppConfigLoader(), $this->createPaymentStatusTransitionValidator(), $this->getRepository(), $this->getEntityManager(), $this->createWebhookMessageSender());
    }

    public function createPaymentStatusTransitionValidator(): PaymentStatusTransitionValidator
    {
        return new PaymentStatusTransitionValidator();
    }

    public function createWebhookMessageSender(): WebhookMessageSender
    {
        return new WebhookMessageSender($this->createMessageSender());
    }

    protected function getPlatformPlugin(): PlatformPluginInterface
    {
        /** @phpstan-var \AppPayment\Zed\Payment\Dependency\Plugin\PlatformPluginInterface */
        return $this->getProvidedDependency(PaymentDependencyProvider::PLUGIN_PLATFORM);
    }

    public function createMessageSender(): MessageSender
    {
        return new MessageSender(new MessageBrokerFacade(), $this->getConfig(), $this->getAppKernelFacade());
    }

    protected function createAppConfigLoader(): AppConfigLoader
    {
        return new AppConfigLoader($this->getAppKernelFacade());
    }

    protected function getAppKernelFacade(): AppKernelFacadeInterface
    {
        return new AppKernelFacade();
    }

    public function createPaymentCancelReservationRequestedMessageHandler(): PaymentCancelReservationRequestedMessageHandlerInterface
    {
        return new PaymentCancelReservationRequestedMessageHandler();
    }

    public function createPaymentConfirmationRequestedMessageHandler(): PaymentConfirmationRequestedMessageHandlerInterface
    {
        return new PaymentConfirmationRequestedMessageHandler(
            $this->getRepository(),
            $this->createTenantIdentifierExtractor(),
            $this->createPaymentCapturer(),
        );
    }

    public function createPaymentRefundRequestedMessageHandler(): PaymentRefundRequestedMessageHandlerInterface
    {
        return new PaymentRefundRequestedMessageHandler();
    }

    public function createTenantIdentifierExtractor(): TenantIdentifierExtractor
    {
        return new TenantIdentifierExtractor();
    }

    public function createPaymentCapturer(): PaymentCapturer
    {
        return new PaymentCapturer($this->getPlatformPlugin(), $this->getEntityManager(), $this->getConfig(), $this->createAppConfigLoader());
    }
}
