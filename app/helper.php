<?php

use App\Enums\UserRoleEnum;

if(!function_exists('getRoleByKey')) {
    function getRoleByKey($key)
    {
        return strtolower(UserRoleEnum::getKey($key));
    }
}
