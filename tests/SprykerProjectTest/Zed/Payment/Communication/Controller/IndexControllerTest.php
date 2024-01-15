<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace AppPaymentTest\Zed\Payment\Communication\Controller;

use Codeception\Stub;
use Codeception\Test\Unit;
use Exception;
use Generated\Shared\Transfer\PaymentPageRequestTransfer;
use Generated\Shared\Transfer\PaymentPageResponseTransfer;
use SprykerProject\Zed\Payment\Business\Message\MessageBuilder;
use SprykerProject\Zed\Payment\Dependency\Plugin\PlatformPaymentPagePluginInterface;
use SprykerProject\Zed\Payment\Dependency\Plugin\PlatformPluginInterface;
use SprykerProject\Zed\Payment\PaymentDependencyProvider;
use AppPaymentTest\Zed\Payment\PaymentCommunicationTester;
use Ramsey\Uuid\Uuid;
use SprykerTest\Shared\Testify\Helper\DependencyHelperTrait;

/**
 * Auto-generated group annotations
 *
 * @group AppPaymentTest
 * @group Zed
 * @group Payment
 * @group Communication
 * @group Controller
 * @group IndexControllerTest
 * Add your own group annotations below this line
 */
class IndexControllerTest extends Unit
{
    use DependencyHelperTrait;

    protected PaymentCommunicationTester $tester;

    public function testPaymentPageRendersSuccessPage(): void
    {
        $tenantIdentifier = Uuid::uuid4()->toString();
        $transactionId = Uuid::uuid4()->toString();

        $this->tester->haveAppConfigForTenant($tenantIdentifier);
        $this->tester->havePaymentForTransactionId($transactionId, $tenantIdentifier);

        $platformPluginMock = Stub::makeEmpty(PlatformPaymentPagePluginInterface::class, [
            'getPaymentPage' => function (PaymentPageRequestTransfer $paymentPageRequestTransfer) use ($transactionId): PaymentPageResponseTransfer {
                // Ensure that required data is passed to the PaymentPlatformPlugin
                $this->assertNotNull($paymentPageRequestTransfer->getPayment());
                $this->assertNotNull($paymentPageRequestTransfer->getAppConfig());
                $this->assertSame($paymentPageRequestTransfer->getTransactionId(), $transactionId);

                $paymentPageResponseTransfer = new PaymentPageResponseTransfer();
                $paymentPageResponseTransfer
                    ->setPaymentPageTemplate('@Payment/Index/success-page.twig')
                    ->setPaymentPageData([]);

                return $paymentPageResponseTransfer;
            },
        ]);

        $this->getDependencyHelper()->setDependency(PaymentDependencyProvider::PLUGIN_PLATFORM, $platformPluginMock);

        $this->tester->amOnPage(sprintf('/payment?tenantIdentifier=%s&transactionId=%s', $tenantIdentifier, $transactionId));
        $this->tester->see('Success page');
    }

    public function testPaymentPageRendersSuccessPageWithoutPaymentPageDataReturnedFromThePaymentPlatformPlugin(): void
    {
        $tenantIdentifier = Uuid::uuid4()->toString();
        $transactionId = Uuid::uuid4()->toString();

        $this->tester->haveAppConfigForTenant($tenantIdentifier);
        $this->tester->havePaymentForTransactionId($transactionId, $tenantIdentifier);

        $platformPluginMock = Stub::makeEmpty(PlatformPaymentPagePluginInterface::class, [
            'getPaymentPage' => function (PaymentPageRequestTransfer $paymentPageRequestTransfer) use ($transactionId): PaymentPageResponseTransfer {
                // Ensure that required data is passed to the PaymentPlatformPlugin
                $this->assertNotNull($paymentPageRequestTransfer->getPayment());
                $this->assertNotNull($paymentPageRequestTransfer->getAppConfig());
                $this->assertSame($paymentPageRequestTransfer->getTransactionId(), $transactionId);

                // Payment page response without payment page data.
                $paymentPageResponseTransfer = new PaymentPageResponseTransfer();
                $paymentPageResponseTransfer
                    ->setPaymentPageTemplate('@Payment/Index/success-page.twig');

                return $paymentPageResponseTransfer;
            },
        ]);

        $this->getDependencyHelper()->setDependency(PaymentDependencyProvider::PLUGIN_PLATFORM, $platformPluginMock);

        $this->tester->amOnPage(sprintf('/payment?tenantIdentifier=%s&transactionId=%s', $tenantIdentifier, $transactionId));
        $this->tester->see('Success page');
    }

    public function testPaymentPageRendersErrorPageWhenTransactionIdNotInRequest(): void
    {
        $this->tester->amOnPage('/payment?tenantIdentifier=tenantIdentifier');
        $this->tester->see('Error page');
        $this->tester->see(MessageBuilder::getTransactionIdOrTenantIdentifierMissingOrEmpty());
    }

    public function testPaymentPageRendersErrorPageWhenTenantIdentifierNotInRequest(): void
    {
        $this->tester->amOnPage('/payment?transactionId=transactionId');
        $this->tester->see('Error page');
        $this->tester->see(MessageBuilder::getTransactionIdOrTenantIdentifierMissingOrEmpty());
    }

    public function testPaymentPageRendersErrorPageWhenTenantIdentifierInRequestDoesNotMatchTheTenantIdentifierFromThePersistedPayment(): void
    {
        $tenantIdentifier = Uuid::uuid4()->toString();
        $transactionId = Uuid::uuid4()->toString();

        $this->tester->haveAppConfigForTenant($tenantIdentifier);
        $this->tester->havePaymentForTransactionId($transactionId, $tenantIdentifier);

        $this->tester->amOnPage(sprintf('/payment?tenantIdentifier=%s&transactionId=%s', 'not matching tenant identifier', $transactionId));
        $this->tester->see('Error page');
        $this->tester->see(MessageBuilder::getInvalidTransactionIdAndTenantIdentifierCombination());
    }

    public function testPaymentPageRendersErrorPageWhenPaymentByIdNotFound(): void
    {
        $tenantIdentifier = Uuid::uuid4()->toString();
        $transactionId = Uuid::uuid4()->toString();

        $platformPluginMock = Stub::makeEmpty(PlatformPaymentPagePluginInterface::class);

        $this->getDependencyHelper()->setDependency(PaymentDependencyProvider::PLUGIN_PLATFORM, $platformPluginMock);

        $this->tester->amOnPage(sprintf('/payment?tenantIdentifier=%s&transactionId=%s', $tenantIdentifier, $transactionId));
        $this->tester->see('Error page');
        $this->tester->see(MessageBuilder::paymentByTransactionIdNotFound($transactionId));
    }

    public function testPaymentPageRendersErrorPageWhenPlatformGetPaymentPageThrowsAnException(): void
    {
        $tenantIdentifier = Uuid::uuid4()->toString();
        $transactionId = Uuid::uuid4()->toString();

        $this->tester->haveAppConfigForTenant($tenantIdentifier);
        $this->tester->havePaymentForTransactionId($transactionId, $tenantIdentifier);

        $platformPluginMock = Stub::makeEmpty(PlatformPaymentPagePluginInterface::class, [
            'getPaymentPage' => static function (): never {
                throw new Exception('GetPaymentPageThrowsAnException');
            },
        ]);

        $this->getDependencyHelper()->setDependency(PaymentDependencyProvider::PLUGIN_PLATFORM, $platformPluginMock);

        $this->tester->amOnPage(sprintf('/payment?tenantIdentifier=%s&transactionId=%s', $tenantIdentifier, $transactionId));
        $this->tester->see('Error page');
        $this->tester->see('GetPaymentPageThrowsAnException');
    }

    public function testPaymentPageRendersErrorPageWhenPlatformDoesNotSupportPaymentPageRendering(): void
    {
        $tenantIdentifier = Uuid::uuid4()->toString();
        $transactionId = Uuid::uuid4()->toString();

        $this->tester->haveAppConfigForTenant($tenantIdentifier);
        $this->tester->havePaymentForTransactionId($transactionId, $tenantIdentifier);

        $platformPluginMock = Stub::makeEmpty(PlatformPluginInterface::class);

        $this->getDependencyHelper()->setDependency(PaymentDependencyProvider::PLUGIN_PLATFORM, $platformPluginMock);

        $this->tester->amOnPage(sprintf('/payment?tenantIdentifier=%s&transactionId=%s', $tenantIdentifier, $transactionId));
        $this->tester->see('Error page');
        $this->tester->see(MessageBuilder::getPlatformPluginDoesNotProvideRenderingAPaymentPage());
    }
}
