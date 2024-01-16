<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace AppPayment\Zed\MessageBroker;

use Spryker\Shared\MessageBrokerAws\MessageBrokerAwsConstants;
use Spryker\Zed\MessageBroker\MessageBrokerConfig as SprykerMessageBrokerConfig;

class MessageBrokerConfig extends SprykerMessageBrokerConfig
{
    /**
     * @return list<string>
     */
    public function getDefaultWorkerChannels(): array
    {
        return [
            'payment-commands',
        ];
    }
}
