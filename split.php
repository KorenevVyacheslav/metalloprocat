<?php
require('traits.php');

/**
 * класс для обработки строки title и значений полей
 * $alloy, $item_standart, $item_size
 */
class Split
{

    use Traits;

    // метод раскладывает title для категории товара - плита
    public static function splitPlita(string $title, $alloy, $item_standart, $item_size)
    {
        $item_3D_size = null;
        $item_steel_mark = null;
        $item_width = null;
        $item_length = null;

        // разбиваем $title на категории
        $category = preg_split("/\s+/", mb_strtolower($title));

        foreach ($category as $value) {

            // если во входном массиве есть параметр size, то в выходном массиве значение этого параметра должно
            // быть заменено на значение из входного массива, а не из title
            if (is_null($item_size) || $item_size == "-") {
                $pattern = '/\d+x\d+x\d+/';                                 // шаблон для размера
                if (preg_match($pattern, $value, $matches)) {           // есть размер в title
                    $item_3D_size = $value;
                }
            } else $item_3D_size = $item_size;

            $alloy = self::defineAlloy($alloy, $value);

            // шаблон для марки стали "09г"
            $item_steel_mark = (preg_match('/09г/u', $value, $matches)) ? $value : null;

        }

        return self::arrayToColumns(
            [
                'item_standart' => self::defineItemStandart($item_standart, $title),
                'item_size' => self::splitSize($item_3D_size)[1],
                'item_width' => self::splitSize($item_3D_size)[2],
                '$item_length' => self::splitSize($item_3D_size)[3],
                'item_wall' => self::splitSize($item_3D_size)[0],
                'alloy' => $alloy,
                'item_steel_mark' => $item_steel_mark
            ]
        );


    }

    // метод раскладывает title для категории товара - лента
    public static function splitLenta(string $title, $alloy, $item_standart, $item_size)
    {
        $item_3D_size = null;
        $item_steel_mark = null;
        $item_width = null;
        $item_length = null;

        // разбиваем $title на категории
        $category = preg_split("/\s+/", mb_strtolower($title));

        foreach ($category as $value) {

            // если во входном массиве есть параметр size, то в выходном массиве значение этого параметра должно
            // быть заменено на значение из входного массива, а не из title
            if (is_null($item_size) || $item_size == "-") {
                $pattern = '/\d+x\d+/';                                 // шаблон для размера
                if (preg_match($pattern, $value, $matches)) {           // есть размер в title
                    $item_3D_size = $value;
                }
            } else $item_3D_size = $item_size;

            $alloy = self::defineAlloy($alloy, $value);

            // шаблон для марки стали "09г"
            $item_steel_mark = (preg_match('/09г/u', $value, $matches)) ? $value : null;

        }

        return self::arrayToColumns(
            [
                'item_standart' => self::defineItemStandart($item_standart, $title),
                'item_width' => self::splitSize($item_3D_size)[2],
                'item_wall' => self::splitSize($item_3D_size)[0],
                'alloy' => $alloy,
                'item_steel_mark' => $item_steel_mark
            ]
        );


    }


    // метод раскладывает title для категории товара - труба
    public static function splitTruba(string $title, $alloy, $item_standart, $item_size)
    {
        $item_3D_size = null;
        $item_steel_mark = null;
        $item_width = null;
        $item_length = null;

        // разбиваем $title на категории
        $category = preg_split("/\s+/", mb_strtolower($title));

        foreach ($category as $value) {

            // если во входном массиве есть параметр size, то в выходном массиве значение этого параметра должно
            // быть заменено на значение из входного массива, а не из title
            if (is_null($item_size) || $item_size == "-") {
                $pattern = '/\d+x\d+x\d+/';                                 // шаблон для размера
                if (preg_match($pattern, $value, $matches)) {           // есть размер в title
                    $item_3D_size = $value;
                }
            } else $item_3D_size = $item_size;

            $alloy = self::defineAlloy($alloy, $value);

            // шаблон для марки стали "09г"
            $item_steel_mark = (preg_match('/09г/u', $value, $matches)) ? $value : null;

        }

        return self::arrayToColumns(
            [
                'item_standart' => self::defineItemStandart($item_standart, $title),
                'item_diameter' => self::splitSize($item_3D_size)[0],
                'item_wall' => self::splitSize($item_3D_size)[2],
                'item_length' => self::splitSize($item_3D_size)[3],
                'alloy' => $alloy,
                'item_steel_mark' => $item_steel_mark
            ]
        );


    }

    // метод преобразует входной массив в другой массив, где все параметры
    // распределены по столбцам
    // на входе массив, построенный по title, на выходе массив столбцов col_name
    public static function arrayToColumns(array $array)
    {

        $new = [];
        foreach ($array as $key => $value) {

            switch ($key) {

                case 'item_standart':
                    $new[] = ['col_name' => 'Стандарт', 'col_code' => 'item_standart', 'value' => $value];
                    break;

                case 'item_size':
                    $new[] = ['col_name' => 'Размер', 'col_code' => 'item_size', 'value' => $value];
                    break;

                case 'item_width':
                    $new[] = ['col_name' => 'Ширина', 'col_code' => 'item_width', 'value' => $value];
                    break;

                case '$item_length':
                    $new[] = ['col_name' => 'Длина', 'col_code' => 'item_length', 'value' => $value];
                    break;

                case 'item_wall':
                    $new[] = ['col_name' => 'Толщина', 'col_code' => 'item_wall', 'value' => $value];
                    break;

                case 'alloy':
                    $new[] = ['col_name' => 'Сплав', 'col_code' => 'alloy', 'value' => mb_strtoupper($value)];
                    break;

                case 'item_steel_mark':
                    $new[] = ['col_name' => 'Марка', 'col_code' => 'item_steel_mark', 'value' => mb_strtoupper($value)];
                    break;

                case 'item_diameter':
                    $new[] = ['col_name' => 'Диаметр', 'col_code' => 'item_diameter', 'value' => mb_strtoupper($value)];
                    break;

            }

        }

        return $new;

    }


}