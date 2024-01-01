<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerProject\Zed\Payment\Business\Payment\Page;

use Generated\Shared\Transfer\PaymentPageRequestTransfer;
use Generated\Shared\Transfer\PaymentPageResponseTransfer;
use SprykerProject\Zed\Payment\Business\Message\MessageBuilder;
use SprykerProject\Zed\Payment\Business\Payment\AppConfig\AppConfigLoader;
use SprykerProject\Zed\Payment\Dependency\Plugin\PlatformPaymentPagePluginInterface;
use SprykerProject\Zed\Payment\Dependency\Plugin\PlatformPluginInterface;
use SprykerProject\Zed\Payment\Persistence\Exception\PaymentByTransactionIdNotFoundException;
use SprykerProject\Zed\Payment\Persistence\PaymentRepositoryInterface;
use Spryker\Shared\Log\LoggerTrait;
use Throwable;

class PaymentPage
{
    use LoggerTrait;

    public function __construct(
        protected PlatformPluginInterface $platformPlugin,
        protected PaymentRepositoryInterface $paymentRepository,
        protected AppConfigLoader $appConfigLoader
    ) {
    }

    public function getPaymentPage(PaymentPageRequestTransfer $paymentPageRequestTransfer): PaymentPageResponseTransfer
    {
        $paymentPageResponseTransfer = new PaymentPageResponseTransfer();
        $paymentPageResponseTransfer
            ->setIsSuccessful(false)
            ->setPaymentPageTemplate('@Payment/index/error-page.twig'); // This is the default error page for all errors that can occur before the PaymentPlatformPlugin is executed.

        if (!$this->platformPlugin instanceof PlatformPaymentPagePluginInterface) {
            return $this->buildErrorPaymentPageResponse($paymentPageResponseTransfer, MessageBuilder::getPlatformPluginDoesNotProvideRenderingAPaymentPage());
        }

        $requestData = $paymentPageRequestTransfer->getRequestDataOrFail();

        if (!$this->validateRequestData($requestData)) {
            return $this->buildErrorPaymentPageResponse($paymentPageResponseTransfer, MessageBuilder::getTransactionIdOrTenantIdentifierMissingOrEmpty());
        }

        $transactionId = $this->getTransactionId($requestData);
        $tenantIdentifier = $this->getTenantIdentifier($requestData);

        try {
            $paymentTransfer = $this->paymentRepository->getByTransactionId($transactionId);
        } catch (PaymentByTransactionIdNotFoundException $paymentByTransactionIdNotFoundException) {
            return $this->buildErrorPaymentPageResponse($paymentPageResponseTransfer, $paymentByTransactionIdNotFoundException->getMessage());
        }

        if ($paymentTransfer->getTenantIdentifier() !== $tenantIdentifier) {
            return $this->buildErrorPaymentPageResponse($paymentPageResponseTransfer, MessageBuilder::getInvalidTransactionIdAndTenantIdentifierCombination(), [
                'Requested transactionId' => $transactionId,
                'Requested tenantIdentifier' => $tenantIdentifier,
                'Payment tenantIdentifier' => $paymentTransfer->getTenantIdentifierOrFail(),
            ]);
        }

        $appConfigTransfer = $this->appConfigLoader->loadAppConfig($tenantIdentifier);

        $paymentPageRequestTransfer->setTransactionIdOrFail($transactionId);
        $paymentPageRequestTransfer->setPaymentOrFail($paymentTransfer);
        $paymentPageRequestTransfer->setAppConfigOrFail($appConfigTransfer);

        try {
            return $this->platformPlugin->getPaymentPage($paymentPageRequestTransfer);
        } catch (Throwable $throwable) {
            return $this->buildErrorPaymentPageResponse($paymentPageResponseTransfer, $throwable->getMessage());
        }
    }

    /**
     * This method will always log the error message and the passed log context.
     *
     * @param array<string, string> $context
     */
    protected function buildErrorPaymentPageResponse(
        PaymentPageResponseTransfer $paymentPageResponseTransfer,
        string $errorMessage,
        array $context = []
    ): PaymentPageResponseTransfer {
        $this->logError($errorMessage, $context);

        $paymentPageData = [
            'errorMessage' => $errorMessage,
        ];
        $paymentPageResponseTransfer->setPaymentPageData($paymentPageData);

        return $paymentPageResponseTransfer;
    }

    // @codingStandardsIgnoreStart
    // For an unknown reason PHPCs is complaining that context could also be a string.
    /**
     * @param array<string, string> $context
     */
    protected function logError(string $errorMessage, array $context): void
    {
        $this->getLogger()->error($errorMessage, $context);
    }

    // @codingStandardsIgnoreEnd

    /**
     * @param array<string, string> $requestData
     */
    protected function getTransactionId(array $requestData): string
    {
        return $requestData['transactionId'];
    }

    /**
     * @param array<string, string> $requestData
     */
    protected function getTenantIdentifier(array $requestData): string
    {
        return $requestData['tenantIdentifier'];
    }

    /**
     * This could be another extension point for letting the `PaymentPlatformPluginInterface` validate the request data.
     *
     * @param array<string, string> $requestData
     */
    protected function validateRequestData(array $requestData): bool
    {
        $isValid = true;

        if (!isset($requestData['transactionId']) || empty($requestData['transactionId'])) {
            $this->logError(MessageBuilder::getRequestTransactionIdIsMissingOrEmpty(), [
                'transactionId' => $requestData['transactionId'] ?? '',
            ]);

            $isValid = false;
        }

        if (!isset($requestData['tenantIdentifier']) || empty($requestData['tenantIdentifier'])) {
            $this->logError(MessageBuilder::getRequestTenantIdentifierIsMissingOrEmpty(), [
                'tenantIdentifier' => $requestData['tenantIdentifier'] ?? '',
            ]);

            $isValid = false;
        }

        return $isValid;
    }
}
