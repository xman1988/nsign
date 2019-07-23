<?php


namespace app\controllers;

use yii\base\Controller;
use Faker\Factory;
use yii\helpers;
use yii;


/**
 * Класс HelpersController
 * Содержит методы для выполнения заданий курса nsign раздела "ХЕЛПЕРЫ":
 * Метод actionTruncate - задание: нужно обрезать строку, по определенному количеству слов. Что бы из 30 слов, выводилось 12.
 * Метод actionTransform - задание: нужно преобразовать строку из created_at в CreatedAt.
 * Метод actionTranslit - задание: нужно строку "Купи слона" преобразовать в "Kupi slona".
 *
 * @package app\controllers
 */
class IndexController extends Controller
{

    /**
     * Метод actionTruncate
     * Обрезает строку, по определенному количеству слов и выводит на экран. Обрезает строку из 30 слов до 12 слов.
     * Для работы использует встроенную библиотеку Faker
     *
     */
    public function actionTruncate()
    {
        //количество слов в строке по умолчанию
        $defaultCountFullString = 30;

        //число слов в строке после укорачивания строки по умолчанию
        $defaultCountCutString = 12;

        // get параметр количества слов в строке
        $countFullLength = (integer)Yii::$app->request->get()['full'];

        // get параметр число слов в строке после укорачивания строки
        $countCutLength = (integer)Yii::$app->request->get()['cut'];

        // проверяем есть ли параметры, если нет - устанавливаем значения по умолчанию
        $countFullLength = (!empty($countFullLength)) ? $countFullLength :  $defaultCountFullString;
        $countCutLength = (!empty($countCutLength)) ? $countCutLength : $defaultCountCutString;

        // подключаем библиотеку Faker
        $faker = Factory::create();

        //создаем произвольную строку
        $string = $faker->sentence($countFullLength, $variableNbWords = false);

        //обрезаем строку в соответствии с параметрами
        $truncatedString = helpers\StringHelper::truncateWords($string, $countCutLength);

        //считаем количество слов в итоговой строке
        $countWords = helpers\StringHelper::countWords($truncatedString);

        //выводим на экран
        echo 'ИТОГОВАЯ строка:' . '</br>' . '<strong>' . $truncatedString . '</strong>' . '</br></br>';
        echo 'Количество слов в ИСХОДНОЙ строке:' . $countFullLength . '</br>';
        echo 'Количество слов в ИТОГОВОЙ строке:' . $countWords . '</br>';


        echo 'Вы можете передать общее количество слов в исходной строке get параметром \'full\' 
               и количество слов до которого необходимо обрезать исходную строку - get параметром \'cut\'. ';
        die;

    }

    /**
     * Метод actionTransform
     * Преобразует строку из created_at в CreatedAt  и выводит на экран.
     *
     */
    public function actionTransform()
    {
        //строка по умолчанию
        $defaultString = 'created_at';

        // get параметр c переданной строкой
        $paramString = (string)Yii::$app->request->get()['string'];

        // проверяем есть ли параметры, если нет - устанавливаем значения по умолчанию
        $string = (!empty($paramString)) ? $paramString : $defaultString;

        $camelString = helpers\Inflector::camelize($string);

        echo $camelString . '</br>';
        echo 'Вы можете передать строку для преобразования get параметром \'string \'. ';

        die;

    }

    /**
     * Метод actionTranslit
     * Преобразует строку "Купи слона" в "Kupi slona"  и выводит на экран.
     *
     */
    public function actionTranslit()
    {

        //строка по умолчанию
        $defaultString = 'Купи слона';

        // get параметр c переданной строкой
        $paramString = (string)Yii::$app->request->get()['string'];

        // проверяем есть ли параметры, если нет - устанавливаем значения по умолчанию
        $string = (!empty($paramString)) ? $paramString : $defaultString;

        $transString = helpers\Inflector::transliterate($string);

        echo $transString . '</br>';
        echo 'Вы можете передать строку, написанную кириллицей, для преобразования в строку, написанную латиницей, get параметром \'string \'. ';

        die;
    }

}
