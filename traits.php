<?php

trait Traits
{

    // метод получает толщину, ширину и длину из размера
    public static function splitSize(string $item_3D_size)
    {

        $item_wall = substr($item_3D_size, 0, strpos($item_3D_size, "x"));          // извлекаем толщину (берем первые символы до х)
        $item_size = substr($item_3D_size, strpos($item_3D_size, "x") + 1);         // извлекаем размер 2D
        $item_width = substr($item_size, 0, strpos($item_size, "x"));              // ширина
        $item_length = substr($item_size, strpos($item_size, "x") + 1);             // длина

        return array($item_wall, $item_size, $item_width, $item_length);
    }


    // метод получения ГОСТ
    public static function defineItemStandart(?string $item_standart, string $title)
    {

        // если ГОСТ не передан на вход функции splitPlita (т.е. во входном массиве нет параметра standard и его надо получить из строки title)
        // то получаем его из title
        if (is_null($item_standart)) {
            $pattern = '/ГОСТ\s\d+/u';
            if (preg_match($pattern, $title, $matches)) {
                $item_standart = $matches[0];
            } else $item_standart = null;
        }
        return $item_standart;
    }

    // метод получения сплава
    public static function defineAlloy(?string $alloy, $value)
    {
        // если во входном массиве есть параметр alloy, то в выходном массиве значение этого параметра должно
        // быть заменено на значение из входного массива, а не из title
        if (is_null($alloy)) {
            $pattern = '/[aа]\d+/u';
            // шаблон для сплава (русская А и латинская А)
            if (preg_match($pattern, $value, $matches)) {
                $alloy = $value;
            }
        }
        return $alloy;
    }


}
