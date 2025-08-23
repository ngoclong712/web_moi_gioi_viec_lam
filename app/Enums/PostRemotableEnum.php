<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class PostRemotableEnum extends Enum
{
    public const REMOTE_ONLY = 1;
    public const OFFICE_ONLY = 2;
    public const HYBRID = 3;
}
