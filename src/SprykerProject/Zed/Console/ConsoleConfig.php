<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerProject\Zed\Console;

use SprykerProject\Shared\Console\ConsoleConstants;
use Spryker\Zed\Console\ConsoleConfig as SprykerConsoleConfig;

class ConsoleConfig extends SprykerConsoleConfig
{
    public function isDevelopmentConsoleCommandsEnabled(): bool
    {
        return (bool)$this->get(ConsoleConstants::ENABLE_DEVELOPMENT_CONSOLE_COMMANDS, false);
    }
}
