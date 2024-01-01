<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerProject\Zed\OauthClient;

use Spryker\Zed\OauthAuth0\Communication\Plugin\OauthClient\Auth0OauthAccessTokenProviderPlugin;
use Spryker\Zed\OauthClient\OauthClientDependencyProvider as SprykerOauthClientDependencyProvider;
use Spryker\Zed\OauthDummy\Communication\Plugin\OauthClient\DummyOauthAccessTokenProviderPlugin;

class OauthClientDependencyProvider extends SprykerOauthClientDependencyProvider
{
    /**
     * @return array<\Spryker\Zed\OauthClientExtension\Dependency\Plugin\OauthAccessTokenProviderPluginInterface>
     */
    protected function getOauthAccessTokenProviderPlugins(): array
    {
        $providers = [];

        // DummyOauth is only available during development and in CI/test
        if (class_exists(DummyOauthAccessTokenProviderPlugin::class)) {
            $providers[] = new DummyOauthAccessTokenProviderPlugin();
        }

        $providers[] = new Auth0OauthAccessTokenProviderPlugin();

        return $providers;
    }
}
