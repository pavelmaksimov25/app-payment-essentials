<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerProjectTest\Zed\Stripe\Helper;

use Codeception\Module;
use Generated\Shared\Transfer\GlueRequestTransfer;
use Generated\Shared\Transfer\WebhookRequestTransfer;
use SprykerProject\Zed\Stripe\Business\StripeFacade;
use SprykerProject\Zed\Stripe\StripeConfig;
use SprykerProjectTest\Shared\AppConfig\Helper\AppConfigHelperTrait;
use SprykerProjectTest\Shared\Payment\Helper\PaymentHelperTrait;
use Ramsey\Uuid\Uuid;
use SprykerTest\Shared\Testify\Helper\ConfigHelperTrait;

class StripeWebhookHelper extends Module
{
    use AppConfigHelperTrait;
    use PaymentHelperTrait;
    use ConfigHelperTrait;

    /**
     * This method creates a webhook request transfer from a payload fixture.
     * It also creates a tenant and a payment for the transaction id.
     * The tenant identifier is added to the webhook request transfer.
     * The payment is added to the webhook request transfer.
     * The transaction id is added to the webhook request transfer.
     * The webhook request transfer is returned.
     */
    public function getWebhookRequestTransfer(string $payloadFixture): WebhookRequestTransfer
    {
        $tenantIdentifier = Uuid::uuid4()->toString();

        $requestPayloadFromFixture = $this->createWebhookRequestPayloadFromFixture($payloadFixture);

        $glueRequestTransfer = (new GlueRequestTransfer())->setContent($requestPayloadFromFixture);

        $webhookRequestTransfer = (new WebhookRequestTransfer())->setContent($requestPayloadFromFixture);
        $webhookRequestTransfer->setAppConfig($this->getAppConfigHelper()->haveAppConfigForTenant($tenantIdentifier));

        $webhookRequestTransfer = (new StripeFacade())->getTransactionIdFromWebhookRequestTransfer($glueRequestTransfer, $webhookRequestTransfer);
        $webhookRequestTransfer->setSignatureHeader($this->createStripeSignatureHeader($requestPayloadFromFixture));

        $this->getPaymentHelper()->havePaymentForTransactionId($webhookRequestTransfer->getTransactionId(), $tenantIdentifier);

        return $webhookRequestTransfer;
    }

    public function getGlueRequestTransfer(string $payloadFixture): GlueRequestTransfer
    {
        $requestPayloadFromFixture = $this->createWebhookRequestPayloadFromFixture($payloadFixture);

        return (new GlueRequestTransfer())->setContent($requestPayloadFromFixture);
    }

    protected function createWebhookRequestPayloadFromFixture(string $fixtureName): string
    {
        return file_get_contents($this->getFixturesPath($fixtureName));
    }

    protected function getFixturesPath(string $fixtureName): string
    {
        $pathTemplate = '%s/%s.json';

        return sprintf($pathTemplate, codecept_data_dir('webhook/stripe/Fixtures'), $fixtureName);
    }

    protected function createStripeSignatureHeader(string $payload): string
    {
        $stripeConfig = $this->getConfigHelper()->getModuleConfig();
        $timeStamp = time();
        $signedPayload = sprintf('%s.%s', $timeStamp, $payload);
        $signatureHash = hash_hmac('sha256', $signedPayload, $stripeConfig->getWebhookKey(StripeConfig::MODE_TEST));
        $signatureHeader = sprintf('t=%s,v1=%s,v0=%s', $timeStamp, $signatureHash, $signatureHash);

        return $signatureHeader;
    }
}
