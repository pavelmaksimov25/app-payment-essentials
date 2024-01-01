<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerProject\Glue\PaymentBackendApi\Mapper\Webhook;

use Generated\Shared\Transfer\GlueRequestTransfer;
use Generated\Shared\Transfer\WebhookRequestTransfer;
use SprykerProject\Glue\PaymentBackendApi\Plugin\PaymentBackendApi\GlueRequestWebhookMapperPluginInterface;

class GlueRequestWebhookMapper implements GlueRequestWebhookMapperInterface
{
    public function __construct(protected ?GlueRequestWebhookMapperPluginInterface $glueRequestWebhookMapperPlugin = null)
    {
    }

    public function mapGlueRequestTransferToWebhookRequestTransfer(
        GlueRequestTransfer $glueRequestTransfer
    ): WebhookRequestTransfer {
        $webhookRequestTransfer = new WebhookRequestTransfer();
        $webhookRequestTransfer->setContent($glueRequestTransfer->getContent());

        if ($this->glueRequestWebhookMapperPlugin instanceof GlueRequestWebhookMapperPluginInterface) {
            return $this->glueRequestWebhookMapperPlugin->mapGlueRequestDataToWebhookRequestTransfer($glueRequestTransfer, $webhookRequestTransfer);
        }

        return $webhookRequestTransfer;
    }
}
