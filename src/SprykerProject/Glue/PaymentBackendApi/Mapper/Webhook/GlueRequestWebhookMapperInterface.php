<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerProject\Glue\PaymentBackendApi\Mapper\Webhook;

use Generated\Shared\Transfer\GlueRequestTransfer;
use Generated\Shared\Transfer\WebhookRequestTransfer;

interface GlueRequestWebhookMapperInterface
{
    public function mapGlueRequestTransferToWebhookRequestTransfer(
        GlueRequestTransfer $glueRequestTransfer
    ): WebhookRequestTransfer;
}
