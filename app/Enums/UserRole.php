<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class UserRole extends Enum
{
    const Administrator =   0;
    const Moderator =   1;
    const Member  = 2;
    const SuperAdministrator  = 3;
}
