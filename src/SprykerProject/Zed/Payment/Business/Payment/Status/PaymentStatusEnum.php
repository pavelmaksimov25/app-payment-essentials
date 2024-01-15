<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace AppPayment\Zed\Payment\Business\Payment\Status;

enum PaymentStatusEnum
{
    /**
     * @var string
     */
    public const STATUS_NEW = 'new';

    /**
     * @var string
     */
    public const STATUS_CAPTURED = 'captured';

    /**
     * @var string
     */
    public const STATUS_CAPTURE_FAILED = 'capture_failed';

    /**
     * @var string
     */
    public const STATUS_CAPTURE_REQUESTED = 'capture_requested';

    /**
     * @var string
     */
    public const STATUS_AUTHORIZED = 'authorized';

    /**
     * @var array<string, array<string>>
     */
    public const ALLOWED_TRANSITIONS = [
        PaymentStatusEnum::STATUS_NEW => [
            PaymentStatusEnum::STATUS_CAPTURED,
            PaymentStatusEnum::STATUS_CAPTURE_FAILED,
            PaymentStatusEnum::STATUS_AUTHORIZED,
            PaymentStatusEnum::STATUS_CAPTURE_REQUESTED,
        ],
        PaymentStatusEnum::STATUS_AUTHORIZED => [
            PaymentStatusEnum::STATUS_CAPTURED,
            PaymentStatusEnum::STATUS_CAPTURE_REQUESTED,
            PaymentStatusEnum::STATUS_CAPTURE_FAILED,
        ],
        PaymentStatusEnum::STATUS_CAPTURE_REQUESTED => [
            PaymentStatusEnum::STATUS_CAPTURED,
            PaymentStatusEnum::STATUS_CAPTURE_FAILED,
        ],
    ];
}
