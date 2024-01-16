<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace AppPayment\Zed\Twig;

use AppCore\Zed\Twig\TwigDependencyProvider as AppCoreTwigDependencyProvider;
use Spryker\Zed\Http\Communication\Plugin\Twig\HttpKernelTwigPlugin;
use Spryker\Zed\Translator\Communication\Plugin\Twig\TranslatorTwigPlugin;

class TwigDependencyProvider extends AppCoreTwigDependencyProvider
{
    /**
     * @return array<\Spryker\Shared\TwigExtension\Dependency\Plugin\TwigPluginInterface>
     */
    protected function getTwigPlugins(): array
    {
        return array_merge(parent::getTwigPlugins(), [
            new HttpKernelTwigPlugin(),
            new TranslatorTwigPlugin(),
        ]);
    }
}
