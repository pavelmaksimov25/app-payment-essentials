<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace AppPayment\Zed\MessageBroker;

use AppCore\Zed\MessageBroker\MessageBrokerDependencyProvider as AppCoreMessageBrokerDependencyProvider;
use AppPayment\Zed\Payment\Communication\Plugin\MessageBroker\PaymentCancelReservationRequestedMessageHandlerPlugin;
use AppPayment\Zed\Payment\Communication\Plugin\MessageBroker\PaymentConfirmationRequestedMessageHandlerPlugin;
use AppPayment\Zed\Payment\Communication\Plugin\MessageBroker\PaymentRefundRequestedMessageHandlerPlugin;
use Spryker\Zed\MessageBroker\Communication\Plugin\MessageBroker\CorrelationIdMessageAttributeProviderPlugin;
use Spryker\Zed\MessageBroker\Communication\Plugin\MessageBroker\TimestampMessageAttributeProviderPlugin;
use Spryker\Zed\OauthClient\Communication\Plugin\MessageBroker\AccessTokenMessageAttributeProviderPlugin;

/**
 * @method \AppPayment\Zed\MessageBroker\MessageBrokerConfig getConfig()
 */
class MessageBrokerDependencyProvider extends AppCoreMessageBrokerDependencyProvider
{
    /**
     * @return array<\Spryker\Zed\MessageBrokerExtension\Dependency\Plugin\MessageAttributeProviderPluginInterface>
     */
    public function getMessageAttributeProviderPlugins(): array
    {
        return array_merge(parent::getMessageAttributeProviderPlugins(), [
            new CorrelationIdMessageAttributeProviderPlugin(),
            new TimestampMessageAttributeProviderPlugin(),
            new AccessTokenMessageAttributeProviderPlugin(),
        ]);
    }

    /**
     * @return array<\Spryker\Zed\MessageBrokerExtension\Dependency\Plugin\MessageHandlerPluginInterface>
     */
    public function getMessageHandlerPlugins(): array
    {
        return array_merge(parent::getMessageHandlerPlugins(), [
            new PaymentCancelReservationRequestedMessageHandlerPlugin(),
            new PaymentConfirmationRequestedMessageHandlerPlugin(),
            new PaymentRefundRequestedMessageHandlerPlugin(),
        ]);
    }
}
