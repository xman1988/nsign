<?php


namespace app\models;

use yii;
use yii\base\Model;



/**
 * Модель PhoneNumbers
 * Выбирает номера для форматирования из колонки number в БД и
 * вставляет отформатированные номера в колонку formatted_phone.
 *
 * @package app\models
 */

class PhoneNumbers extends Model
{

    /**
     * Метод getNumbers
     * Выбирает номера для форматирования из колонки number в БД
     *
     * @return array|string В случае успеха возвращает массив с данными,
     * в случае неуспеха - строку с сообщением.
     */

	public function getNumbers(){
		$rows = (new \yii\db\Query())
			->select([])
			->from('phone_numbers')
            ->where(['formatted_phone'=> null])
			->all();
        if(empty($rows)){
            return 'Номер телефона УЖЕ конвертирован и ДОБАВЛЕН в БД';
        }
		return $rows;
	}


    /**
     * Метод setPhones
     * Вставляет отформатированные номера в колонку formatted_phone.
     *
     * @param string $id Номер ID cтроки для вставки.
     * @param string $formattedPhone Отформатированная строка для вставки.
     *
     * @return string Сообщение о результате вставки
     */

	public function setPhones($id, $formattedPhone){
		$rows = Yii::$app->db->createCommand("UPDATE phone_numbers SET formatted_phone ='$formattedPhone' WHERE id ='$id'")->execute();
		if($rows){
		    return 'Номер телефона '. $formattedPhone .' добавлен в БД';
        }
		return 'Что-то пошло не так. Номер телефона  '. $formattedPhone .'  НЕ добавлен в БД';

	}
}