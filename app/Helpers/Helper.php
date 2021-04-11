<?php
namespace App\Helpers;

class Helper
{
    /**
     * 指定された確率でtrueを返す
     * @param [type] $percentage
     * @return boolean
     */
    public static function setPercentage($percentage): bool
    {
        $rand = rand(1, 100);
        if ($rand <= $percentage) {
            return true;
        } else {
            return false;
        }
    }
}