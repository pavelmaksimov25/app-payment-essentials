<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerProjectTest\Zed\Stripe\Communication\Plugin\Webhook;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\WebhookRequestTransfer;
use SprykerProject\Zed\Stripe\Communication\Plugin\Webhook\GlueRequestWebhookMapperPlugin;
use SprykerProjectTest\Zed\Stripe\StripeCommunicationTester;

/**
 * Auto-generated group annotations
 *
 * @group SprykerProjectTest
 * @group Zed
 * @group Stripe
 * @group Communication
 * @group Plugin
 * @group Webhook
 * @group GlueRequestWebhookMapperPluginTest
 * Add your own group annotations below this line
 */
class GlueRequestWebhookMapperPluginTest extends Unit
{
    protected StripeCommunicationTester $tester;

    /**
     * @return void
     */
    public function testGetTransactionIdFromWebhookRequestTransferIsSuccessful(): void
    {
        // Arrange
        $glueRequestTransfer = $this->tester->getGlueRequestTransfer('valid-webhook-payload-succeeded');

        // Act
        $glueRequestTransferToWebhookTransferMapperPlugin = new GlueRequestWebhookMapperPlugin();
        $paymentPageResponseTransfer = $glueRequestTransferToWebhookTransferMapperPlugin->mapGlueRequestDataToWebhookRequestTransfer($glueRequestTransfer, new WebhookRequestTransfer());

        $this->assertNotNull($paymentPageResponseTransfer->getTransactionId());
    }
}
