<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerProject\Zed\Payment\Dependency\Plugin;

use Generated\Shared\Transfer\AppConfigTransfer;
use Generated\Shared\Transfer\AppConfigValidateResponseTransfer;
use Generated\Shared\Transfer\CapturePaymentRequestTransfer;
use Generated\Shared\Transfer\CapturePaymentResponseTransfer;
use Generated\Shared\Transfer\InitializePaymentRequestTransfer;
use Generated\Shared\Transfer\InitializePaymentResponseTransfer;
use Generated\Shared\Transfer\WebhookRequestTransfer;
use Generated\Shared\Transfer\WebhookResponseTransfer;

interface PlatformPluginInterface
{
    /**
     * Specification:
     * - Receives a `AppConfigTransfer` with the current App/Tenant Configuration in the `AppConfigTransfer::content`.
     * - Returns a `AppConfigValidateResponseTransfer`.
     * - Requires `AppConfigValidateResponseTransfer::isSuccessful`to be set.
     * - Requires `AppConfigValidateResponseTransfer::configurationValidationErrors` when the validation of the configuration has errors.
     *
     * @api
     */
    public function validateConfiguration(AppConfigTransfer $appConfigTransfer): AppConfigValidateResponseTransfer;

    /**
     * Specification:
     * - Receives a `InitializePaymentRequestTransfer` with:
     *   - `InitializePaymentRequestTransfer::orderData` (QuoteTransfer)
     *   - `InitializePaymentRequestTransfer::QuoteTransfer::currencyCode`
     *   - `InitializePaymentRequestTransfer::QuoteTransfer::grandTotal`
     *   - `InitializePaymentRequestTransfer::QuoteTransfer::orderReference`
     * - Returns a `InitializePaymentResponseTransfer`.
     * - Requires `InitializePaymentResponseTransfer::isSuccessful`to be set.
     * - Requires `InitializePaymentResponseTransfer::message` to be set when the 3rd party provider could not process the request.
     * - Returns a `InitializePaymentResponseTransfer` with a failed response when the 3rd party provider could not process the request.
     * - Returns a `InitializePaymentResponseTransfer` with a successful response when the 3rd party provider was able to process the request.
     * - Requires to return a `InitializePaymentResponseTransfer::transactionId` with a successful response when the 3rd party provider was able to process the request.
     *
     * @api
     */
    public function initializePayment(InitializePaymentRequestTransfer $initializePaymentRequestTransfer): InitializePaymentResponseTransfer;

    /**
     * Specification:
     * - Receives a `WebhookRequestTransfer` with:
     *   - `WebhookRequestTransfer::payment` (PaymentTransfer)
     *   - `WebhookRequestTransfer::appConfig (AppConfigTransfer)`
     *   - `WebhookRequestTransfer::content`
     * - Returns a `WebhookResponseTransfer`.
     * - Requires `WebhookResponseTransfer::isSuccessful`to be set.
     * - Requires `WebhookResponseTransfer::message` to be set when the 3rd party provider could not process the request.
     * - Returns a `WebhookResponseTransfer` with a failed response when the 3rd party provider could not process the request.
     * - Returns a `WebhookResponseTransfer` with a successful response when the 3rd party provider was able to process the request.
     *
     * @api
     */
    public function handleWebhook(WebhookRequestTransfer $webhookRequestTransfer): WebhookResponseTransfer;

    /**
     * Specification:
     * - Tries to Capture Payment for an existing PaymentIntent.
     * - Requires `CapturePaymentRequestTransfer::transactionId`to be set.
     * - Requires `CapturePaymentRequestTransfer::appConfig`to be set.
     * - Returns a `CapturePaymentResponseTransfer`.
     * - Requires `CapturePaymentResponseTransfer::isSuccessful`to be set.
     * - Requires `CapturePaymentResponseTransfer::message` to be set when the 3rd party provider could not process the request.
     * - Returns a `CapturePaymentResponseTransfer` with a failed response status and message when the 3rd party provider could not process the request.
     *
     * @api
     */
    public function capturePayment(CapturePaymentRequestTransfer $capturePaymentRequestTransfer): CapturePaymentResponseTransfer;
}
