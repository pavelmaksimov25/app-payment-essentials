<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace AppPayment\Glue\PaymentBackendApi\Mapper\Webhook;

use Generated\Shared\Transfer\GlueResponseTransfer;
use Generated\Shared\Transfer\WebhookResponseTransfer;

interface GlueResponseWebhookMapperInterface
{
    public function mapWebhookResponseTransferToSingleResourceGlueResponseTransfer(
        WebhookResponseTransfer $webhookResponseTransfer
    ): GlueResponseTransfer;
}
