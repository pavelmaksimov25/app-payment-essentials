<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerProjectTest\Shared\AppConfig\Helper;

use Codeception\Module;

trait AppConfigHelperTrait
{
    protected function getAppConfigHelper(): AppConfigHelper
    {
        /** @var \SprykerProjectTest\Shared\AppConfig\Helper\AppConfigHelper $appConfigHelper */
        $appConfigHelper = $this->getModule('\\' . AppConfigHelper::class);

        return $appConfigHelper;
    }

    abstract protected function getModule(string $name): Module;
}
