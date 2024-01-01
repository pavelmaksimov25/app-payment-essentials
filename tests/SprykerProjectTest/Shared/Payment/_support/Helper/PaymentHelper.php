<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerProjectTest\Shared\Payment\Helper;

use Codeception\Module;
use Generated\Shared\DataBuilder\CapturePaymentRequestBuilder;
use Generated\Shared\DataBuilder\InitializePaymentRequestBuilder;
use Generated\Shared\DataBuilder\PaymentBuilder;
use Generated\Shared\DataBuilder\QuoteBuilder;
use Generated\Shared\Transfer\CapturePaymentRequestTransfer;
use Generated\Shared\Transfer\InitializePaymentRequestTransfer;
use Generated\Shared\Transfer\PaymentPageRequestTransfer;
use Generated\Shared\Transfer\PaymentTransfer;
use Orm\Zed\Payment\Persistence\SpyPaymentQuery;
use SprykerProject\Zed\Payment\Business\Payment\Status\PaymentStatusEnum;
use SprykerProject\Zed\Payment\Persistence\PaymentEntityManager;
use SprykerProject\Zed\Payment\Persistence\PaymentRepository;
use SprykerProjectTest\Shared\AppConfig\Helper\AppConfigHelperTrait;
use Ramsey\Uuid\Uuid;
use SprykerTest\Shared\Testify\Helper\DataCleanupHelperTrait;

class PaymentHelper extends Module
{
    use DataCleanupHelperTrait;
    use AppConfigHelperTrait;

    public function assertPaymentIsInState(string $transactionId, string $expectedState): void
    {
        $paymentEntity = SpyPaymentQuery::create()->findOneByTransactionId($transactionId);

        $this->assertNotNull($paymentEntity, sprintf('Could not find a payment with transaction id "%s".', $transactionId));
        $this->assertSame($expectedState, $paymentEntity->getStatus(), sprintf('Expected payment to be in status "%s" but got "%s"', $expectedState, $paymentEntity->getStatus()));
    }

    public function havePaymentForTransactionId(
        string $transactionId,
        string $tenantIdentifier,
        string $status = PaymentStatusEnum::STATUS_NEW
    ): PaymentTransfer {
        $quoteBuilder = new QuoteBuilder();
        $quoteBuilder->withItem()
            ->withAnotherItem();

        $paymentTransfer = (new PaymentBuilder())->build();
        $quoteTransfer = $quoteBuilder->build();
        $paymentTransfer
            ->setTransactionId($transactionId)
            ->setTenantIdentifier($tenantIdentifier)
            ->setQuote($quoteTransfer)
            ->setOrderReference($quoteTransfer->getOrderReference())
            ->setStatus($status);

        $paymentEntityManager = new PaymentEntityManager();
        $paymentTransfer = $paymentEntityManager->createPayment($paymentTransfer);

        return $paymentTransfer;
    }

    public function haveInitializePaymentRequestTransfer(array $seed = []): InitializePaymentRequestTransfer
    {
        $tenantIdentifier = $seed[InitializePaymentRequestTransfer::TENANT_IDENTIFIER] ?? Uuid::uuid4()->toString();
        $quoteBuilder = new QuoteBuilder();
        $quoteBuilder->withItem()
            ->withAnotherItem();

        $initializePaymentRequestTransfer = (new InitializePaymentRequestBuilder($seed))->build();
        $initializePaymentRequestTransfer->setOrderData($quoteBuilder->build());
        $initializePaymentRequestTransfer->setTenantIdentifier($tenantIdentifier);

        return $initializePaymentRequestTransfer;
    }

    /**
     * This method should only be used by the PlatformPluginInterface implementation tests.
     * It Provides a request transfer as it would come from the Payment module.
     */
    public function haveInitializePaymentRequestWithAppConfigTransfer(array $seed = []): InitializePaymentRequestTransfer
    {
        $tenantIdentifier = $seed[InitializePaymentRequestTransfer::TENANT_IDENTIFIER] ?? Uuid::uuid4()->toString();
        $quoteBuilder = new QuoteBuilder();
        $quoteBuilder->withItem()
            ->withAnotherItem();

        $initializePaymentRequestTransfer = (new InitializePaymentRequestBuilder($seed))->build();
        $initializePaymentRequestTransfer->setOrderData($quoteBuilder->build());
        $initializePaymentRequestTransfer->setTenantIdentifier($tenantIdentifier);

        $appConfigTransfer = $this->getAppConfigHelper()->haveAppConfigForTenant($tenantIdentifier);

        $initializePaymentRequestTransfer->setAppConfig($appConfigTransfer);

        return $initializePaymentRequestTransfer;
    }

    public function havePaymentPageRequestTransfer(array $seed = []): PaymentPageRequestTransfer
    {
        $tenantIdentifier = Uuid::uuid4()->toString();
        $transactionId = Uuid::uuid4()->toString();

        $appConfigTransfer = $this->getAppConfigHelper()->haveAppConfigForTenant($tenantIdentifier);
        $paymentTransfer = $this->havePaymentForTransactionId($transactionId, $tenantIdentifier);

        $paymentPageRequestTransfer = new PaymentPageRequestTransfer();
        $paymentPageRequestTransfer
            ->setPayment($paymentTransfer)
            ->setAppConfig($appConfigTransfer)
            ->setTransactionId($transactionId);

        return $paymentPageRequestTransfer;
    }

    public function haveCapturePaymentRequestTransfer(array $seed = []): CapturePaymentRequestTransfer
    {
        $tenantIdentifier = $seed['tenantIdentifier'] ?? Uuid::uuid4()->toString();
        $transactionId = $seed['transactionId'] ?? Uuid::uuid4()->toString();

        $appConfigTransfer = $this->getAppConfigHelper()->haveAppConfigForTenant($tenantIdentifier);
        $paymentTransfer = $this->havePaymentForTransactionId($transactionId, $tenantIdentifier);

        $capturePaymentRequestTransfer = (new CapturePaymentRequestBuilder($seed))->build();
        $capturePaymentRequestTransfer
            ->setPayment($paymentTransfer)
            ->setAppConfig($appConfigTransfer)
            ->setTransactionId($transactionId);

        return $capturePaymentRequestTransfer;
    }

    public function getPaymentTransferByTransactionId(string $transactionId): PaymentTransfer
    {
        return (new PaymentRepository())->getByTransactionId($transactionId);
    }
}
