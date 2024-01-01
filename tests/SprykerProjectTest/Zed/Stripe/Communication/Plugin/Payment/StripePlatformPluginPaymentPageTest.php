<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerProjectTest\Zed\Stripe\Communication\Plugin\Payment;

use Codeception\Test\Unit;
use SprykerProject\Zed\Stripe\Communication\Plugin\Payment\StripePlatformPlugin;
use SprykerProjectTest\Zed\Stripe\StripeCommunicationTester;
use Ramsey\Uuid\Uuid;
use Spryker\Zed\Translator\Business\TranslatorFacade;
use Stripe\PaymentIntent;

/**
 * Auto-generated group annotations
 *
 * @group SprykerProjectTest
 * @group Zed
 * @group Stripe
 * @group Communication
 * @group Plugin
 * @group Payment
 * @group StripePlatformPluginPaymentPageTest
 * Add your own group annotations below this line
 */
class StripePlatformPluginPaymentPageTest extends Unit
{
    protected StripeCommunicationTester $tester;

    public function testGetPaymentPageReturnsSuccessfulResponse(): void
    {
        // Arrange
        $clientSecret = Uuid::uuid4()->toString();
        $transactionId = Uuid::uuid4()->toString();

        $paymentPageRequestTransfer = $this->tester->havePaymentPageRequestTransfer();

        $this->tester->mockPaymentIntentResponse([
            'client_secret' => $clientSecret,
            'amount' => $paymentPageRequestTransfer->getPayment()->getQuote()->getGrandTotal(),
            'currency' => $paymentPageRequestTransfer->getPayment()->getQuote()->getCurrencyCode(),
            'metadata' => $this->tester->getExpectedMetadata(),
            'status' => PaymentIntent::STATUS_REQUIRES_PAYMENT_METHOD,
        ], [], 'retrieve', $transactionId);

        // Act
        $stripePlatformPlugin = new StripePlatformPlugin();
        $stripePlatformPlugin->setFacade($this->tester->getFacade());

        $paymentPageResponseTransfer = $stripePlatformPlugin->getPaymentPage($paymentPageRequestTransfer);

        $this->assertTrue($paymentPageResponseTransfer->getIsSuccessful(), 'Expected to have a successful response bot got a failed one.');
    }

    public function testGetPaymentPageReturnsErrorResponseWhenStatusOfPaymentIsNotInStateRequiresPaymentMethod(): void
    {
        // Arrange
        $clientSecret = Uuid::uuid4()->toString();
        $transactionId = Uuid::uuid4()->toString();

        $paymentPageRequestTransfer = $this->tester->havePaymentPageRequestTransfer();

        $this->tester->mockPaymentIntentResponse([
            'client_secret' => $clientSecret,
            'amount' => $paymentPageRequestTransfer->getPayment()->getQuote()->getGrandTotal(),
            'currency' => $paymentPageRequestTransfer->getPayment()->getQuote()->getCurrencyCode(),
            'metadata' => $this->tester->getExpectedMetadata(),
            'status' => 'not accepted status',
        ], [], 'retrieve', $transactionId);

        // Act
        $stripePlatformPlugin = new StripePlatformPlugin();
        $stripePlatformPlugin->setFacade($this->tester->getFacade());

        $paymentPageResponseTransfer = $stripePlatformPlugin->getPaymentPage($paymentPageRequestTransfer);

        $this->assertFalse($paymentPageResponseTransfer->getIsSuccessful(), 'Expected to have a failed response bot got a successful one.');
        $this->assertSame($paymentPageResponseTransfer->getPaymentPageData()['errorMessage'], (new TranslatorFacade())->trans('payment.payment_page.url_expired'));
    }

    public function testGetPaymentPageReturnsErrorResponseWhenStripeIntentsReceiveThrowsAnException(): void
    {
        $paymentPageRequestTransfer = $this->tester->havePaymentPageRequestTransfer();

        $this->tester->mockPaymentIntentThatThrowsAnExceptionOnMethodCall('retrieve');

        $stripePlatformPlugin = new StripePlatformPlugin();
        $stripePlatformPlugin->setFacade($this->tester->getFacade());

        $paymentPageResponseTransfer = $stripePlatformPlugin->getPaymentPage($paymentPageRequestTransfer);

        $this->assertFalse($paymentPageResponseTransfer->getIsSuccessful(), 'Expected to have a failed response bot got a successful one.');
    }
}
