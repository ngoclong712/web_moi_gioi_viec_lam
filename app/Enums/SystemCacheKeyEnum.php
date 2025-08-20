<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class SystemCacheKeyEnum extends Enum
{
    public const POST_CITIES = 'post_cities';
    public const CONFIGS = 'configs';
}
