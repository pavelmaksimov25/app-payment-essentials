<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace AppPaymentTest\Glue\PaymentBackendApi\Helper;

use Codeception\Module;
use Generated\Shared\Transfer\InitializePaymentResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Orm\Zed\Payment\Persistence\SpyPaymentQuery;
use SprykerProject\Zed\Payment\Persistence\PaymentRepository;
use Spryker\Shared\Config\Config;
use Spryker\Shared\GlueBackendApiApplication\GlueBackendApiApplicationConstants;
use Spryker\Shared\ZedRequest\ZedRequestConstants;
use SprykerTest\Shared\Testify\Helper\DependencyHelperTrait;
use SprykerTest\Shared\Testify\Helper\LocatorHelperTrait;
use Symfony\Component\HttpFoundation\Response;

class PaymentBackendApiHelper extends Module
{
    use LocatorHelperTrait;
    use DependencyHelperTrait;

    public function buildPaymentUrl(): string
    {
        return $this->buildBackendApiUrl('private/initialize-payment');
    }

    public function buildWebhookUrl(): string
    {
        return $this->buildBackendApiUrl('webhooks');
    }

    /**
     * @param array<mixed>|string $params
     */
    protected function buildBackendApiUrl(string $url, array $params = []): string
    {
        $url = sprintf('%s://%s/%s', Config::get(ZedRequestConstants::ZED_API_SSL_ENABLED) ? 'https' : 'http', Config::get(GlueBackendApiApplicationConstants::GLUE_BACKEND_API_HOST), $this->formatUrl($url, $params));

        return rtrim($url, '/');
    }

    /**
     * @param array<mixed>|string $params
     */
    protected function formatUrl(string $url, array $params): string
    {
        $refinedParams = [];
        foreach ($params as $key => $value) {
            $refinedParams['{' . $key . '}'] = urlencode($value);
        }

        return strtr($url, $refinedParams);
    }

    public function assertPaymentWithTransactionIdExists(string $transactionId): void
    {
        $spyPaymentQuery = new SpyPaymentQuery();
        $paymentEntity = $spyPaymentQuery->findOneByTransactionId($transactionId);

        $this->assertNotNull($paymentEntity, sprintf('Expected to find a persisted payment with transaction id "%s" but it was not found in the database', $transactionId));
    }

    public function assertSamePaymentQuoteAndRequestQuote(string $transactionId, QuoteTransfer $quoteTransfer): void
    {
        $paymentRepository = new PaymentRepository();
        $paymentTransfer = $paymentRepository->getByTransactionId($transactionId);

        $this->assertNotNull($paymentTransfer, sprintf('Expected to find a persisted payment with transaction id "%s" but it was not found in the database', $transactionId));

        $this->assertSame($quoteTransfer->toArray(), $paymentTransfer->getQuote()->toArray(), 'Expected that the persisted quote is the same as the one from the authorize request.');
    }

    public function assertResponseHasErrorMessage(Response $response): void
    {
        $response = json_decode($response->getContent(), true);

        $initializePaymentResponseTransfer = (new InitializePaymentResponseTransfer())->fromArray($response['data']['attributes']);

        $this->assertIsString($initializePaymentResponseTransfer->getMessage());
    }
}
