<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerProject\Glue\PaymentBackendApi\Plugin\GlueApplication;

use SprykerProject\Glue\PaymentBackendApi\Controller\InitializePaymentResourceController;
use SprykerProject\Glue\PaymentBackendApi\Controller\WebhooksController;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\RouteProviderPluginInterface;
use Spryker\Glue\Kernel\Backend\AbstractPlugin;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

/**
 * @codeCoverageIgnore This class will only be used when caching is disabled. Without this Plugin the InitializePayment request would fail and we would see an issue right away.
 */
class PaymentBackendApiRouteProviderPlugin extends AbstractPlugin implements RouteProviderPluginInterface
{
    public function addRoutes(RouteCollection $routeCollection): RouteCollection
    {
        $routeCollection->add('postPayment', $this->getPostPaymentRoute());
        $routeCollection->add('postWebhook', $this->getPostWebhookRoute());

        return $routeCollection;
    }

    public function getPostPaymentRoute(): Route
    {
        return (new Route('/private/initialize-payment'))
            ->setDefaults([
                '_controller' => [InitializePaymentResourceController::class, 'postAction'],
                '_resourceName' => 'Payment',
            ])
            ->setMethods(Request::METHOD_POST);
    }

    public function getPostWebhookRoute(): Route
    {
        return (new Route('/webhooks'))
            ->setDefaults([
                '_controller' => [WebhooksController::class, 'postAction'],
                '_resourceName' => 'Payment',
            ])
            ->setMethods(Request::METHOD_POST);
    }
}
