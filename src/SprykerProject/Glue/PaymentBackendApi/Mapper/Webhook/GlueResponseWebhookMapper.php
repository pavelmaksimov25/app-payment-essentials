<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerProject\Glue\PaymentBackendApi\Mapper\Webhook;

use Generated\Shared\Transfer\GlueErrorTransfer;
use Generated\Shared\Transfer\GlueResourceTransfer;
use Generated\Shared\Transfer\GlueResponseTransfer;
use Generated\Shared\Transfer\WebhookResponseTransfer;
use Symfony\Component\HttpFoundation\Response;

class GlueResponseWebhookMapper implements GlueResponseWebhookMapperInterface
{
    public function mapWebhookResponseTransferToSingleResourceGlueResponseTransfer(
        WebhookResponseTransfer $webhookResponseTransfer
    ): GlueResponseTransfer {
        $glueResponseTransfer = new GlueResponseTransfer();

        $glueResourceTransfer = new GlueResourceTransfer();
        $glueResourceTransfer->setAttributes($glueResponseTransfer);
        $glueResourceTransfer->setType('payment');

        $glueResponseTransfer->addResource($glueResourceTransfer);
        $glueResponseTransfer->setHttpStatus(Response::HTTP_OK);

        if ($webhookResponseTransfer->getIsSuccessful() !== true) {
            $glueResponseTransfer->setHttpStatus(Response::HTTP_BAD_REQUEST);
            $glueResponseTransfer->addError((new GlueErrorTransfer())->setMessage($webhookResponseTransfer->getMessage()));
        }

        return $glueResponseTransfer;
    }
}
