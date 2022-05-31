<?php

namespace app\widgets;

class StarWidget extends \yii\base\Widget
{

    CONST STAR_RAITING = 5;

    public static function getStars ($items)
    {
        $stars = floor($items);
        $dif = self::STAR_RAITING - $stars;
        $filedStars = '';
        $unfiledStars = '';
        for ($i = 1; $i <= $stars; $i++){
            $filedStars = $filedStars . "<span class=\"fill-star\">&nbsp;</span>";
        }
        for ($i = 1; $i <= $dif; $i++){
            $filedStars = $filedStars . "<span>&nbsp;</span>";
        }
        return $filedStars . $unfiledStars;
    }
}
