<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerProject\Zed\Payment\Dependency\Plugin;

use Generated\Shared\Transfer\WebhookRequestTransfer;

/**
 * We offer two ways of getting the transaction id for the Payment module to be able to find a related PaymentTransfer for this transaction inside the Payment Module.
 *
 * 1. The `PlatformPaymentPluginTransactionIdAwareInterface` is used when the transaction id is available in the `WebhookRequestTransfer::content` and only the Payment Provider implementation knows where this is located in the webhook data.
 * 2. The `\SprykerProject\Glue\PaymentBackendApi\Plugin\PaymentBackendApi\GlueRequestWebhookMapperPluginInterface` is used when the transaction id is available e.g. in request headers or in the URL.
 *
 * Depending on the Payment Provider implementation choose the right interface to implement.
 */
interface PlatformPluginTransactionIdAwareInterface extends PlatformPluginInterface
{
    /**
     * Specification:
     * - Receives a `WebhookRequestTransfer` with:
     *   - `WebhookRequestTransfer::content`
     * - Returns a TenantIdentifier string.
     *
     * @api
     */
    public function getTransactionIdFromWebhookData(WebhookRequestTransfer $webhookRequestTransfer): string;
}
