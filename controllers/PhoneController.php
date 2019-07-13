<?php


namespace app\controllers;

use yii\web\Controller;
use app\models\PhoneNumbers;


/**
 * Класс PhoneController
 * Форматирует номера из БД в номера телефонов согласно маске, указанной в свойстве $mask,
 * используя регулярное выражение в свойстве $replacePattern.
 *
 * @var string $replacePattern Регулярное выражение по которому форматируются номера
 * @var string $mask Маска(формат) телефонного номера
 *
 * @package app\controllers
 */

class PhoneController extends Controller
{
	public $replacePattern = '/^(\d{3})(\d{3})(\d{2})(\d{2})$/';
	public $mask = '+7($1)-$2-$3-$4';

    /**
     * Метод actionIndex
     * Берет значения номеров из БД конвертирует, согласно регулярному выражению
     * и записывает обратно в БД
     *
     * @return string Сообщение о результате форматирования номера и вставке его в БД
     */

	public function actionIndex()
	{
	    // Подключаем модель
		$phones = new PhoneNumbers();

        // Берем неотформатированные номера из БД
		$arrNumbers = $phones->getNumbers();
		if(!is_array($arrNumbers)){
		    return $arrNumbers;
        }
		foreach ($arrNumbers as $item){

            // Форматируем номер
			$currentNumber[$item['id']] = $this->asPhone($item['number']);
			if($currentNumber[$item['id']] === null){
			    return 'Ошибка при конвертации номера $item[\'number\']';
            }

            // Выводим сообщение о результате форматирования номера и вставки его в БД
			return $phones->setPhones($item['id'], $currentNumber[$item['id']]);
		}
	}

    /**
     * Метод asPhone
     * Берет значения номеров из БД конвертирует, согласно регулярному выражению
     * и записывает обратно в БД
     *
     * @param string $number Строка для замены.
     * @return string Отформатированная в соответствии с шаблоном строка номера
     */

	public function asPhone($number)
	{
		return preg_replace($this->replacePattern, $this->mask, $number);
	}
}