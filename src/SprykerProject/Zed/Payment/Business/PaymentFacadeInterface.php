<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerProject\Zed\Payment\Business;

use Generated\Shared\Transfer\AppConfigTransfer;
use Generated\Shared\Transfer\AppDisconnectTransfer;
use Generated\Shared\Transfer\GlueRequestTransfer;
use Generated\Shared\Transfer\GlueRequestValidationTransfer;
use Generated\Shared\Transfer\InitializePaymentRequestTransfer;
use Generated\Shared\Transfer\InitializePaymentResponseTransfer;
use Generated\Shared\Transfer\PaymentCancelReservationRequestedTransfer;
use Generated\Shared\Transfer\PaymentConfirmationRequestedTransfer;
use Generated\Shared\Transfer\PaymentPageRequestTransfer;
use Generated\Shared\Transfer\PaymentPageResponseTransfer;
use Generated\Shared\Transfer\PaymentRefundRequestedTransfer;
use Generated\Shared\Transfer\WebhookRequestTransfer;
use Generated\Shared\Transfer\WebhookResponseTransfer;

interface PaymentFacadeInterface
{
    /**
     * Specification:
     * - Converts the `GlueRequestTransfer::getContent()` data from a JSON string into a `AppConfigTransfer`.
     * - Calls `PaymentPlatformPluginInterface::validateConfiguration()` and passes the `AppConfigTransfer`.
     * - When `PaymentPlatformPluginInterface::validateConfiguration()` throws an exception, the exception is logged.
     * - When `PaymentPlatformPluginInterface::validateConfiguration()` throws an exception, a `GlueRequestValidationTransfer` with a failed response is returned.
     * - When `PaymentPlatformPluginInterface::validateConfiguration()` is successful, a `GlueRequestValidationTransfer` with HTTP Status Code 200 (OK) is returned.
     * - When `PaymentPlatformPluginInterface::validateConfiguration()` is not successful, validation errors from the `AppConfigValidateResponseTransfer` are converted
     *   to error messages and added to the `GlueRequestValidationTransfer`.
     * - When `PaymentPlatformPluginInterface::validateConfiguration()` is NOT successful, a `GlueRequestValidationTransfer` with HTTP Status Code 422 (UNPROCESSABLE ENTITY) is returned.
     * - Requires `GlueRequestTransfer::getContent()`.
     *
     * @api
     */
    public function validatePaymentConfiguration(GlueRequestTransfer $glueRequestTransfer): GlueRequestValidationTransfer;

    /**
     * Specification:
     * - Calls the `PaymentPlatformPluginInterface::initializePayment()` method.
     * - When `PaymentPlatformPluginInterface::initializePayment()` throws an exception, the exception is logged.
     * - When `PaymentPlatformPluginInterface::initializePayment()` throws an exception, a `InitializePaymentResponseTransfer` with a failed response is returned.
     * - When `PaymentPlatformPluginInterface::initializePayment()` is successful, the `InitializePaymentResponseTransfer::redirectUrl` will be set to the current application.
     * - When `PaymentPlatformPluginInterface::initializePayment()` is successful, a `SpyPayment` entity will be persisted.
     * - When `PaymentPlatformPluginInterface::initializePayment()` is successful, a `InitializePaymentResponseTransfer` with a successful response is returned.
     *
     * @api
     */
    public function initializePayment(InitializePaymentRequestTransfer $initializePaymentRequestTransfer): InitializePaymentResponseTransfer;

    /**
     * Specification:
     * - Validates the `$requestData`:
     *   - Requires `$requestData['transactionId']`.
     *   - Requires `$requestData['tenantIdentifier']`.
     * - When one of the required fields is not given or empty, an error will be logged.
     * - When one of the required fields is not given or empty, a `PaymentPageResponseTransfer` with a failed response will be returned.
     * - When one of the required fields is not given or empty, the default error page will be rendered.
     * - Loads the in the `PaymentFacadeInterface::initializePayment()` method persisted `PaymentTransfer`.
     * - When no Payment entity found for the given `transactionId`, an error will be logged.
     * - When no Payment entity found for the given `transactionId`, the default error page will be rendered.
     * - Validates the `PaymentTransfer::tenantIdentifier` with the one passed by the request.
     * - When the passed `tenantIdentifier` does not match with the persisted one, an error will be logged.
     * - When the passed `tenantIdentifier` does not match with the persisted one, the default error page will be rendered.
     * - Loads the `AppConfigTransfer` for the passed `tenantIdentifier`.
     * - Calls the `PaymentPlatformPluginInterface::getPaymentPage()` method.
     * - When `PaymentPlatformPluginInterface::getPaymentPage()` throws an exception, the exception is logged.
     * - When `PaymentPlatformPluginInterface::getPaymentPage()` throws an exception, a `PaymentPageResponseTransfer` with a failed response is returned.
     * - When `PaymentPlatformPluginInterface::getPaymentPage()` usSuccessful, a `PaymentPageResponseTransfer` with a successful response is returned.
     *
     * @api
     */
    public function getPaymentPage(PaymentPageRequestTransfer $paymentPageRequestTransfer): PaymentPageResponseTransfer;

    /**
     * Specification:
     * - Loads the in the `PaymentFacadeInterface::initializePayment()` method persisted `PaymentTransfer`.
     * - When no Payment entity found for the given `transactionId`, an error will be logged.
     * - Validates the `PaymentTransfer::tenantIdentifier` with the one passed by the request.
     * - When the passed `tenantIdentifier` does not match with the persisted one, an error will be logged.
     * - Loads the `AppConfigTransfer` for the passed `tenantIdentifier`.
     * - Calls the `PaymentPlatformPluginInterface::handleWebhook()` method.
     * - When `PaymentPlatformPluginInterface::handleWebhook()` throws an exception, the exception is logged.
     * - When `PaymentPlatformPluginInterface::handleWebhook()` throws an exception, a `WebhookResponseTransfer` with a failed response is returned.
     * - When `PaymentPlatformPluginInterface::handleWebhook()` usSuccessful, a `WebhookResponseTransfer` with a successful response is returned.
     *
     * @api
     */
    public function handleWebhook(WebhookRequestTransfer $webhookRequestTransfer): WebhookResponseTransfer;

    /**
     * Specification
     * - Sends a `PaymentMethodAdded` message when the AppConfiguration is in state NEW.
     * - Updates the AppConfiguration and sets its state to connected after the `PaymentMethodAdded` message was sent.
     * - When the AppConfiguration is in state CONNECTED the `PaymentMethodAdded` message will not be sent.
     *
     * @api
     */
    public function sendPaymentMethodAddedMessage(AppConfigTransfer $appConfigTransfer): AppConfigTransfer;

    /**
     * Specification
     * - Sends a `PaymentMethodDeleted` message when the AppConfiguration is removed.
     *
     * @api
     */
    public function sendPaymentMethodDeletedMessage(AppDisconnectTransfer $appDisconnectTransfer): AppDisconnectTransfer;

    /**
     * Specification:
     * - Handles the `PaymentCancelReservationRequested` message.
     *
     * @api
     */
    public function handlePaymentCancelReservationRequested(PaymentCancelReservationRequestedTransfer $paymentCancelReservationRequestedTransfer): void;

    /**
     * Specification:
     * - Handles the `PaymentConfirmationRequested` message.
     *
     * @api
     */
    public function handlePaymentConfirmationRequested(PaymentConfirmationRequestedTransfer $paymentConfirmationRequestedTransfer): void;

    /**
     * Specification:
     * - Handles the `PaymentRefundRequested` message.
     *
     * @api
     */
    public function handlePaymentRefundRequested(PaymentRefundRequestedTransfer $paymentRefundRequestedTransfer): void;
}
