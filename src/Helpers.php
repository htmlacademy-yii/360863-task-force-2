<?php

namespace TaskForce;

use app\models\Review;

class Helpers
{
    /**
     * Возвращает корректную форму множественного числа
     * Ограничения: только для целых чисел
     *
     * Пример использования:
     * $remaining_minutes = 5;
     * echo "Я поставил таймер на {$remaining_minutes} " .
     *     get_noun_plural_form(
     *         $remaining_minutes,
     *         'минута',
     *         'минуты',
     *         'минут'
     *     );
     * Результат: "Я поставил таймер на 5 минут"
     *
     * @param int $number Число, по которому вычисляем форму множественного числа
     * @param string $one Форма единственного числа: яблоко, час, минута
     * @param string $two Форма множественного числа для 2, 3, 4: яблока, часа, минуты
     * @param string $many Форма множественного числа для остальных чисел
     *
     * @return string Рассчитанная форма множественнго числа
     */
    public static function get_noun_plural_form(int $number, string $one, string $two, string $many): string
    {
        $number = (int)$number;
        $mod10 = $number % 10;
        $mod100 = $number % 100;

        switch (true) {
            case (($mod100 >= 11 && $mod100 <= 20) || $mod10 > 5):
                return $many;

            case ($mod10 === 1):
                return $one;

            case ($mod10 >= 2 && $mod10 <= 4):
                return $two;

            default:
                return $many;
        }
    }

    /**
     * Форматирует и возвращает дату.
     * @param string $dateCreate Дата вида "2022-04-07 23:58"
     *
     * @return string форматированная дата
     */
    public static function getTimePassed(string $dateCreate): string
    {
        $timeNow = date_create(date("Y-m-d H:i"));
        $dateCreated = date_create($dateCreate);
        $timePassed = date_diff($dateCreated, $timeNow);
        $days = $timePassed->format('%a');
        $hours = $timePassed->format('%h');
        $minutes = $timePassed->format('%i');
        if ($days == 0 & $hours == 0 & $minutes >= 0) {
            return $minutes . ' ' . self::get_noun_plural_form($minutes, 'минуту', 'минуты', 'минут') . ' ' . 'назад';
        } elseif ($days == 0 & $hours >= 1) {
            return $hours . ' ' . self::get_noun_plural_form($hours, 'час', 'часа', 'часов') . ' ' . 'назад';
        } else {
            return $days . ' ' . self::get_noun_plural_form($days, 'день', 'дня', 'дней') . ' назад';
        }
    }

    public static function formatDate(string $date): string
    {
        $newDate = date_create($date);

        $month = [
            0,
            'января',
            'февраля',
            'марта',
            'апреля',
            'мая',
            'июня',
            'июля',
            'августа',
            'сентября',
            'октября',
            'ноября',
            'декабря'
        ];

        $month = $month[date('n')];
        $day = date_format($newDate, 'd');
        $year = date_format($newDate, 'Y');
        $time = date_format($newDate, 'H:i');

        return "$day $month $year, $time";
    }

    public static function getAge(string $date): string
    {
        $timeNow = date_create(date("Y-m-d H:i"));
        $dateCreated = date_create($date);
        $timePassed = date_diff($dateCreated, $timeNow);

        $years = $timePassed->format('%Y');

        // Если число заканчивается на 1
        if(preg_match("|(1)$|",$years))
        {
            $comment='год';
        }   // Если число заканчивается на 2,3,4
        elseif(preg_match("/(2|3|4)$/",$years))
        {
            $comment='года';
        }
        else
        {
            $comment='лет';
        }

        // Если заканчивается на 10-19
        if(preg_match("/(1)[0-9]$/",$years))
        {
            $comment='лет';
        }

        return "$years $comment" ;

    }

}
