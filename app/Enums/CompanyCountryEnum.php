<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class CompanyCountryEnum extends Enum
{
    public const VN = 'Vietnam';
    public const JP = 'Japan';
    public const CN = 'China';
    public const US = 'United States';
    public const UK = 'United Kingdom';
    public const KR = 'Korea';
}
