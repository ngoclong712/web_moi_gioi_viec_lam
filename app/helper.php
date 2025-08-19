<?php

use App\Enums\SystemCacheKeyEnum;
use App\Enums\UserRoleEnum;
use App\Models\Post;

if(!function_exists('getRoleByKey')) {
    function getRoleByKey($key)
    {
        return strtolower(UserRoleEnum::getKey($key));
    }
}

if(!function_exists('getPostCities')) {
    function getAndCachePostCities(): array
    {
        return cache()->remember(
            SystemCacheKeyEnum::POST_CITIES,
            60*60*24*30,
            function () {
                $cities = Post::query()
                    ->pluck('city');
                $arrCity = [];
                foreach ($cities as $city) {
                    if (empty($city)) {
                        continue;
                    }
                    $arr = explode(',', $city);
                    foreach ($arr as $item) {
                        if (in_array(trim($item), $arrCity)) {
                            continue;
                        }
                        $arrCity[] = trim($item);
                    }
                }

                return $arrCity;
            }
        );
    }
}
