<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerProjectTest\Zed\Stripe\Communication\Plugin\Payment;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\AppConfigTransfer;
use SprykerProject\Zed\Stripe\Communication\Plugin\Payment\StripePlatformPlugin;
use SprykerProjectTest\Zed\Stripe\StripeCommunicationTester;

/**
 * Auto-generated group annotations
 *
 * @group SprykerProjectTest
 * @group Zed
 * @group Stripe
 * @group Communication
 * @group Plugin
 * @group Payment
 * @group StripePlatformPluginValidateConfigurationTest
 * Add your own group annotations below this line
 */
class StripePlatformPluginValidateConfigurationTest extends Unit
{
    protected StripeCommunicationTester $tester;

    public function testValidateConfigurationReturnsFailedResponseWhenAccountIdIsMissing(): void
    {
        // Arrange
        $appConfigTransfer = new AppConfigTransfer();

        $this->tester->mockStripeAccountsResponse(false);

        // Act
        $stripePlatformPlugin = new StripePlatformPlugin();
        $stripePlatformPlugin->setFacade($this->tester->getFacade());

        $appConfigValidateResponseTransfer = $stripePlatformPlugin->validateConfiguration($appConfigTransfer);

        // Assert
        // Symfony's required validation default message
        $this->tester->assertConfigurationValidateResponseHasTranslatedErrorMessage($appConfigValidateResponseTransfer, 'accountId', 'This field is missing.');
    }

    public function testValidateConfigurationReturnsFailedResponseWhenPaymentPageLabelIsMissing(): void
    {
        // Arrange
        $appConfigTransfer = new AppConfigTransfer();
        $appConfigTransfer->setConfig(['accountId' => 'accountId']);

        $this->tester->mockStripeAccountsResponse(false);

        // Act
        $stripePlatformPlugin = new StripePlatformPlugin();
        $stripePlatformPlugin->setFacade($this->tester->getFacade());

        $appConfigValidateResponseTransfer = $stripePlatformPlugin->validateConfiguration($appConfigTransfer);

        // Assert
        // Symfony's required validation default message
        $this->tester->assertConfigurationValidateResponseHasTranslatedErrorMessage($appConfigValidateResponseTransfer, 'paymentPageLabel', 'This field is missing.');
    }

    public function testValidateConfigurationReturnsFailedResponseWhenAccountIdIsNotConnectedToPlatformAccount(): void
    {
        // Arrange
        $appConfigTransfer = new AppConfigTransfer();
        $appConfigTransfer->setConfig(['accountId' => 'acct_xxxxx', 'paymentPageLabel' => 'paymentPageLabel']);

        $this->tester->mockStripeAccountsResponse(false);

        // Act
        $stripePlatformPlugin = new StripePlatformPlugin();
        $stripePlatformPlugin->setFacade($this->tester->getFacade());

        $appConfigValidateResponseTransfer = $stripePlatformPlugin->validateConfiguration($appConfigTransfer);

        // Assert
        // This message should not be there anymore because it's set in the AppConfig
        $this->tester->assertConfigurationValidateResponseDoesNotHaveTranslatedErrorMessage($appConfigValidateResponseTransfer, 'accountId', 'Stripe AccountID is required');
        $this->tester->assertConfigurationValidateResponseHasTranslatedErrorMessage($appConfigValidateResponseTransfer, 'accountId', 'Stripe account is not connected to the platform account');
    }

    public function testValidateConfigurationReturnsSuccessfulResponseWhenAccountIdIsConnectedToPlatformAccountAndModeIsSelected(): void
    {
        // Arrange
        $appConfigTransfer = new AppConfigTransfer();
        $appConfigTransfer->setConfig(['accountId' => 'acct_xxxxx', 'mode' => 'test', 'paymentPageLabel' => 'paymentPageLabel']);

        $this->tester->mockStripeAccountsResponse(true);

        // Act
        $stripePlatformPlugin = new StripePlatformPlugin();
        $stripePlatformPlugin->setFacade($this->tester->getFacade());

        $appConfigValidateResponseTransfer = $stripePlatformPlugin->validateConfiguration($appConfigTransfer);

        // Assert
        $this->assertTrue($appConfigValidateResponseTransfer->getIsSuccessful(), 'Expected to have a successful response but got failed one.');
    }

    public function testValidateConfigurationReturnsFailedResponseWhenModeIsMissing(): void
    {
        // Arrange
        $appConfigTransfer = new AppConfigTransfer();
        $appConfigTransfer->setConfig(['accountId' => 'acct_xxxxx', 'paymentPageLabel' => 'paymentPageLabel']);

        $this->tester->mockStripeAccountsResponse(true);

        // Act
        $stripePlatformPlugin = new StripePlatformPlugin();
        $stripePlatformPlugin->setFacade($this->tester->getFacade());

        $appConfigValidateResponseTransfer = $stripePlatformPlugin->validateConfiguration($appConfigTransfer);

        // Assert
        // Symfony's required validation default message
        $this->tester->assertConfigurationValidateResponseHasTranslatedErrorMessage($appConfigValidateResponseTransfer, 'mode', 'This field is missing.');
    }

    public function testValidateConfigurationReturnsFailedResponseWhenModeHasInvalidFormat(): void
    {
        // Arrange
        $appConfigTransfer = new AppConfigTransfer();
        $appConfigTransfer->setConfig(['mode' => 'test-invalid']);

        $this->tester->mockStripeAccountsResponse(false);

        // Act
        $stripePlatformPlugin = new StripePlatformPlugin();
        $stripePlatformPlugin->setFacade($this->tester->getFacade());

        $appConfigValidateResponseTransfer = $stripePlatformPlugin->validateConfiguration($appConfigTransfer);

        // Assert
        $this->tester->assertConfigurationValidateResponseHasTranslatedErrorMessage($appConfigValidateResponseTransfer, 'mode', 'Invalid environment');
    }
}
