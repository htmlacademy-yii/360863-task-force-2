<?php

namespace TaskForce;

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
    static function get_noun_plural_form(int $number, string $one, string $two, string $many): string
    {
        $number = (int)$number;
        $mod10 = $number % 10;
        $mod100 = $number % 100;

        switch (true) {
            case ($mod100 >= 11 && $mod100 <= 20):
                return $many;

            case ($mod10 > 5):
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
    static function getTimePassed(string $dateCreate): string
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
}
