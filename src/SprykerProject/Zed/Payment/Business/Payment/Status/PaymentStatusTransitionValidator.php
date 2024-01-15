<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace AppPayment\Zed\Payment\Business\Payment\Status;

class PaymentStatusTransitionValidator
{
    public function isTransitionAllowed(string $sourceState, string $targetState): bool
    {
        $transitions = PaymentStatusEnum::ALLOWED_TRANSITIONS[$sourceState] ?? [];

        return in_array($targetState, $transitions, true);
    }
}
