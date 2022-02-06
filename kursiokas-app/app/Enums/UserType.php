<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class UserType extends Enum
{
	const Guest = -1;
    const Administrator = 0;
    const Lecturer = 1;
    const Member = 2;
}
