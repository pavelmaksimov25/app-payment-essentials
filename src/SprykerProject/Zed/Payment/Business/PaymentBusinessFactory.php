<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerProject\Zed\Payment\Business;

use SprykerProject\Zed\Payment\Business\MessageBroker\PaymentCancelReservationRequestedMessageHandler;
use SprykerProject\Zed\Payment\Business\MessageBroker\PaymentCancelReservationRequestedMessageHandlerInterface;
use SprykerProject\Zed\Payment\Business\MessageBroker\PaymentConfirmationRequestedMessageHandler;
use SprykerProject\Zed\Payment\Business\MessageBroker\PaymentConfirmationRequestedMessageHandlerInterface;
use SprykerProject\Zed\Payment\Business\MessageBroker\PaymentRefundRequestedMessageHandler;
use SprykerProject\Zed\Payment\Business\MessageBroker\PaymentRefundRequestedMessageHandlerInterface;
use SprykerProject\Zed\Payment\Business\MessageBroker\TenantIdentifier\TenantIdentifierExtractor;
use SprykerProject\Zed\Payment\Business\Payment\AppConfig\AppConfigLoader;
use SprykerProject\Zed\Payment\Business\Payment\Capture\PaymentCapturer;
use SprykerProject\Zed\Payment\Business\Payment\Initialize\PaymentInitializer;
use SprykerProject\Zed\Payment\Business\Payment\Message\MessageSender;
use SprykerProject\Zed\Payment\Business\Payment\Page\PaymentPage;
use SprykerProject\Zed\Payment\Business\Payment\Payment;
use SprykerProject\Zed\Payment\Business\Payment\Status\PaymentStatusTransitionValidator;
use SprykerProject\Zed\Payment\Business\Payment\Validate\ConfigurationValidator;
use SprykerProject\Zed\Payment\Business\Payment\Webhook\WebhookHandler;
use SprykerProject\Zed\Payment\Business\Payment\Webhook\WebhookMessageSender;
use SprykerProject\Zed\Payment\Dependency\Plugin\PlatformPluginInterface;
use SprykerProject\Zed\Payment\PaymentDependencyProvider;
use Spryker\Service\UtilEncoding\UtilEncodingService;
use Spryker\Zed\AppKernel\Business\AppKernelFacade;
use Spryker\Zed\AppKernel\Business\AppKernelFacadeInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use Spryker\Zed\MessageBroker\Business\MessageBrokerFacade;

/**
 * @method \SprykerProject\Zed\Payment\PaymentConfig getConfig()
 * @method \SprykerProject\Zed\Payment\Persistence\PaymentEntityManagerInterface getEntityManager()
 * @method \SprykerProject\Zed\Payment\Persistence\PaymentRepositoryInterface getRepository()
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
        /** @phpstan-var \SprykerProject\Zed\Payment\Dependency\Plugin\PlatformPluginInterface */
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
