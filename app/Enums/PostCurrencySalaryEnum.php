<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class PostCurrencySalaryEnum extends Enum
{
    public const VND = 1;
    public const USD = 2;
    public const EUR = 3;
    public const JPY = 4;
    public const KRW = 5;
    public const CNY = 6;

    public static function getLocaleByValue($key)
    {
        $locales = [
            self::VND => 'vi_VN',
            self::USD => 'en_US',
            self::EUR => 'en_EU',
            self::JPY => 'ja_JP',
            self::KRW => 'ko_KR',
            self::CNY => 'zh_CN',
        ];

        return $locales[$key];
    }
}
