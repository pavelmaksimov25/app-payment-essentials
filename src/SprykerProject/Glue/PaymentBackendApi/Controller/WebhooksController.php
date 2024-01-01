<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerProject\Glue\PaymentBackendApi\Controller;

use Generated\Shared\Transfer\GlueRequestTransfer;
use Generated\Shared\Transfer\GlueResponseTransfer;
use Spryker\Glue\Kernel\Backend\Controller\AbstractController;

/**
 * @method \SprykerProject\Glue\PaymentBackendApi\PaymentBackendApiFactory getFactory()
 */
class WebhooksController extends AbstractController
{
    public function postAction(GlueRequestTransfer $glueRequestTransfer): GlueResponseTransfer
    {
        $webhookRequestTransfer = $this->getFactory()->createGlueRequestWebhookMapper()->mapGlueRequestTransferToWebhookRequestTransfer($glueRequestTransfer);
        $webhookRequestTransfer = $this->getFactory()->getPaymentFacade()->handleWebhook($webhookRequestTransfer);

        return $this->getFactory()->createGlueResponseWebhookMapper()->mapWebhookResponseTransferToSingleResourceGlueResponseTransfer($webhookRequestTransfer);
    }
}
