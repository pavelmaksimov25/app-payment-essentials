<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace SprykerProjectTest\Glue\PaymentBackendApi;

use Codeception\Actor;

/**
 * Inherited Methods
 *
 * @method void wantTo($text)
 * @method void wantToTest($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause($vars = [])
 *
 * @SuppressWarnings(\SprykerProjectTest\Glue\PaymentBackendApi\PHPMD)
 */
class PaymentBackendApiTester extends Actor
{
    use _generated\PaymentBackendApiTesterActions;

    public function seeResponseJsonContainsPayment(): void
    {
        $this->seeResponseJsonPathContains(['data' => ['type' => 'payment']]);
    }
}