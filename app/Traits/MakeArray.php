<?php

namespace App\Traits;

trait MakeArray
{

    /**
     * make collection to array
     * @param $collection , $key
     * @return array
     */
    private function makeArray($collection, string $key)
    {
        if (null === $collection) return;
        $usersArr = [];
        foreach ($collection as $item) {
            $usersArr[] = $item->pivot->$key;
        }
        return $usersArr;
    }

}
