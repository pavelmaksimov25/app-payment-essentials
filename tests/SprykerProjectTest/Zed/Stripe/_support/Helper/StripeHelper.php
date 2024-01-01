<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerProjectTest\Zed\Stripe\Helper;

use Codeception\Module;
use Codeception\Stub;
use Generated\Shared\Transfer\AppConfigValidateResponseTransfer;
use SprykerProject\Zed\Stripe\Business\Client\StripeClientFactory;
use SprykerProject\Zed\Stripe\StripeConfig;
use Spryker\Zed\Translator\Business\TranslatorFacade;
use Spryker\Zed\Translator\Business\TranslatorFacadeInterface;
use SprykerTest\Zed\Testify\Helper\Business\BusinessHelperTrait;
use Stripe\Exception\ApiErrorException;
use Stripe\Exception\PermissionException;
use Stripe\PaymentIntent;
use Stripe\Service\AccountService;
use Stripe\Service\PaymentIntentService;
use Stripe\StripeClient as Client;
use Stripe\StripeObject;

class StripeHelper extends Module
{
    use BusinessHelperTrait;

    protected ?TranslatorFacadeInterface $translatorFacade = null;

    protected function getTranslatorFacade(): TranslatorFacadeInterface
    {
        if (!$this->translatorFacade instanceof TranslatorFacadeInterface) {
            $this->translatorFacade = new TranslatorFacade();
        }

        return $this->translatorFacade;
    }

    public function assertConfigurationValidateResponseHasTranslatedErrorMessage(
        AppConfigValidateResponseTransfer $appConfigValidateResponseTransfer,
        string $field,
        string $message
    ): void {
        $messageFound = false;

        foreach ($appConfigValidateResponseTransfer->getConfigurationValidationErrors() as $configurationValidationErrorTransferCollection) {
            if ($configurationValidationErrorTransferCollection->getProperty() !== $field) {
                continue;
            }

            foreach ($configurationValidationErrorTransferCollection->getErrorMessages() as $errorMessage) {
                if ($errorMessage !== $message) {
                    continue;
                }

                $messageFound = true;
            }
        }

        $this->assertTrue($messageFound, sprintf('Expected to find "%s" error message for the field "%s" but was not found. Either it does not exists or it was not translated.', $message, $field));
    }

    public function assertConfigurationValidateResponseDoesNotHaveTranslatedErrorMessage(
        AppConfigValidateResponseTransfer $appConfigValidateResponseTransfer,
        string $field,
        string $message
    ): void {
        $messageFound = false;
        $translatedMessage = $this->getTranslatorFacade()->trans($message);

        foreach ($appConfigValidateResponseTransfer->getConfigurationValidationErrors() as $configurationValidationErrorTransferCollection) {
            if ($configurationValidationErrorTransferCollection->getProperty() !== $field) {
                continue;
            }

            foreach ($configurationValidationErrorTransferCollection->getErrorMessages() as $errorMessage) {
                if ($errorMessage !== $translatedMessage) {
                    continue;
                }

                $messageFound = true;
            }
        }

        $this->assertFalse($messageFound, sprintf('Expected not to find "%s" error message for the field "%s" but was found.', $translatedMessage, $field));
    }

    /**
     * This mocks the PaymentIntent class which gets returned from the call to StripeClient::paymentIntents.
     */
    public function mockStripeAccountsResponse(bool $accountExists): void
    {
        $stripeAccountServiceMock = Stub::make(AccountService::class, [
            'retrieve' => static function () use ($accountExists): void {
                if (!$accountExists) {
                    throw new PermissionException();
                }
            },
        ]);

        $clientMock = Stub::make(Client::class, [
            'accounts' => $stripeAccountServiceMock,
        ]);

        $this->addStripeClientMock($clientMock);
    }

    /**
     * This mocks the PaymentIntent class which gets returned from the call to StripeClient::paymentIntents.
     *
     * @param array $paymentIntentMock Use this for the Stub to mock methods or properties of the PaymentIntent class.
     * @param array $constructorArgs Use this for the Stub to be constructed.
     */
    public function mockPaymentIntentResponse(array $paymentIntentMock, array $constructorArgs, string $paymentIntentMethod): void
    {
        $paymentIntentMock = Stub::construct(PaymentIntent::class, $constructorArgs, $paymentIntentMock);

        $paymentIntentServiceMock = Stub::make(PaymentIntentService::class, [
            $paymentIntentMethod => static function () use ($paymentIntentMock) {
                return $paymentIntentMock;
            },
        ]);

        $clientMock = Stub::make(Client::class, [
            'paymentIntents' => $paymentIntentServiceMock,
        ]);

        $this->addStripeClientMock($clientMock);
    }

    /**
     * This mocks the PaymentIntent class which will always throw an ApiErrorException.
     */
    public function mockPaymentIntentThatThrowsAnExceptionOnMethodCall(string $exceptionThrowingPaymentIntentMethod): void
    {
        $paymentIntentServiceMock = Stub::make(PaymentIntentService::class, [
            $exceptionThrowingPaymentIntentMethod => static function (): never {
                $internalException = new class extends ApiErrorException {
                };

                throw new $internalException('Payment has failed.');
            },
        ]);

        $clientMock = Stub::make(Client::class, [
            'paymentIntents' => $paymentIntentServiceMock,
        ]);

        $this->addStripeClientMock($clientMock);
    }

    protected function addStripeClientMock(object $clientMock): void
    {
        $stripeClientFactoryMock = Stub::construct(StripeClientFactory::class, [new StripeConfig()], [
            'createStripeClient' => $clientMock, // Mock this method as we want to test the configuration which would be not tested by mocking `platformClient`
        ]);

        $config = [
            StripeConfig::SECRET_KEY => StripeConfig::SECRET_KEY,
            StripeConfig::PUBLISHABLE_KEY => StripeConfig::PUBLISHABLE_KEY,
        ];

        $paymentConfigMock = Stub::make(StripeConfig::class, [
            'getStripeTestConfiguration' => $config,
        ]);

        $this->getBusinessHelper()->mockFactoryMethod('createStripeClientFactory', $stripeClientFactoryMock);
        $this->getBusinessHelper()->mockFactoryMethod('getConfig', $paymentConfigMock);
    }

    public function getExpectedMetadata(): StripeObject
    {
        $stripeObject = new StripeObject();
        $stripeObject->successPageUrl = 'www.my-awesome-shop.com/success';
        $stripeObject->backUrl = 'www.my-awesome-shop.com/back';

        return $stripeObject;
    }
}
