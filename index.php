<?php

require('split.php');
require('inputArray.php');

echo '<pre>';

/** @var Type $jsonArray1 */
$data1 = json_decode($jsonArray1, true);


class TransitionToNewArray
{
    public static $data = [];                // можно без объявления, не используется как статическое свойство класса

    public static function createNewArray(array $data)
    {
        $arrOut = [];                       // массив на выходе метода

        foreach ($data as $key => $value) {
            $concatenate = '';          // переменная для конкатенации

            foreach ($value as $key2 => $value2) {
                $concatenate .= $value2 . '|';
            }

            // если сплав существует во входном массиве
            $alloy = $value['alloy'] ?? null;

            // если стандарт существует во входном массиве
            $item_standart = $value['standard'] ?? null;

            // если размер существует во входном массиве
            $item_size = $value['size'] ?? null;

            $arrOut [$value['item_id']] = array(                       // ключ по каждой позиции - это item_id
                'name' => $value['category'],                        // в поле name подставляется значение из поля category
                'columns' => array(

                    'col_name' => self::splitTitle($value['title'], $alloy, $item_standart, $item_size),
                    'company_name' => 'ООО МеталлТорг',                      // согласно таблице это значение одинаковое для всех категорий
                    'company_city' => 'Москва',                              // согласно таблице это значение одинаковое для всех категорий
                    'company_price' => 50000,                                // согласно таблице это значение одинаковое для всех категорий
                    'item_count' => 100,                                     // согласно таблице это значение одинаковое для всех категорий
                    'concatenated_params' => $concatenate
                )
            );
        }

        return $arrOut;
    }

    public static function splitTitle(string $title, $alloy, $item_standart, $item_size)
    {

        // получаем category из строки title
        // исходим из предположения, что самое первое слово в title - это обязательно категория!
        $array = explode(' ', mb_strtolower($title));
        $category = $array[0];

        // для каждой категории разбиваем title по разному
        // исходим из предположения, что самое первое слово - это обязательно категория
        switch ($category) {
            case 'плита':
                $array = Split::splitPlita($title, $alloy, $item_standart, $item_size);
                break;
            case 'лента':
                $array = Split::splitLenta($title, $alloy, $item_standart, $item_size);
                break;
            case 'труба':
                $array = Split::splitTruba($title, $alloy, $item_standart, $item_size);
                break;

            default:
                echo "Такой категории нет. Проверьте title во входном массиве"; die();
                break;
        }

        return $array;
    }

}

$q = TransitionToNewArray::createNewArray($data1);

print_r($q);


