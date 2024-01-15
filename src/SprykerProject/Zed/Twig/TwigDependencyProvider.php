<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace AppPayment\Zed\Twig;

use Spryker\Shared\Twig\Plugin\DebugTwigPlugin;
use Spryker\Shared\Twig\Plugin\RoutingTwigPlugin;
use Spryker\Zed\Application\Communication\Plugin\Twig\ApplicationTwigPlugin;
use Spryker\Zed\Gui\Communication\Plugin\Twig\AssetsPathTwigPlugin;
use Spryker\Zed\Http\Communication\Plugin\Twig\HttpKernelTwigPlugin;
use Spryker\Zed\Scheduler\Communication\Plugin\Twig\SchedulerTwigPlugin;
use Spryker\Zed\Translator\Communication\Plugin\Twig\TranslatorTwigPlugin;
use Spryker\Zed\Twig\Communication\Plugin\FilesystemTwigLoaderPlugin;
use Spryker\Zed\Twig\TwigDependencyProvider as SprykerTwigDependencyProvider;
use Spryker\Zed\WebProfiler\Communication\Plugin\Twig\WebProfilerTwigLoaderPlugin;

class TwigDependencyProvider extends SprykerTwigDependencyProvider
{
    /**
     * @return array<\Spryker\Shared\TwigExtension\Dependency\Plugin\TwigPluginInterface>
     */
    protected function getTwigPlugins(): array
    {
        return [
            new DebugTwigPlugin(),
            new HttpKernelTwigPlugin(),
            new RoutingTwigPlugin(),
            new ApplicationTwigPlugin(),
            new TranslatorTwigPlugin(),
            new AssetsPathTwigPlugin(),
            new SchedulerTwigPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Shared\TwigExtension\Dependency\Plugin\TwigLoaderPluginInterface>
     */
    protected function getTwigLoaderPlugins(): array
    {
        $plugins = [
            new FilesystemTwigLoaderPlugin(),
        ];

        if (class_exists(WebProfilerTwigLoaderPlugin::class)) {
            $plugins[] = new WebProfilerTwigLoaderPlugin();
        }

        return $plugins;
    }
}
