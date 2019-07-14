<?php


namespace app\models;


use yii\base\Model;

/**
 * Модель Xml
 * Модель работы с XML файлами, как с БД
 * Подключает XML файлы, объявляет атрибуты для фильтрации во view,
 * создает связный массив из отдельных связных XML файлов,
 * получает имена
 *
 * @var integer $id Атрибут - первичный ключ
 * @var integer $categoryId Атрибут - связь между XML таблицами
 * @var integer $price Атрибут - цена товара
 * @var string $name Атрибут - наименование товара
 * @var integer $hidden Атрибут - скрытность наименования
 *
 * @package app\models
 */
class Xml extends Model
{
    public $id;
    public $categoryId;
    public $price;
    public $name;
    public $hidden;


    /**
     * Метод определяет активные аттрибуты
     *
     * @return array возвращает список активных аттрибутов
     */
    public function rules()
    {
        // только поля определенные в rules() будут доступны для поиска
        return [
            [['id', 'categoryId', 'price', 'hidden', 'name'], 'safe'],
        ];
    }

    /**
     * Метод подключает файлы XML, парсит и связывает их между собой
     *
     * @return array возвращает связный массив данных из XML файлов
     */
    public function getXmlData()
    {
        $xml_prod = simplexml_load_file('..\xml\products.xml');
        $xml_cat = simplexml_load_file('..\xml\categories.xml');


        $newXmlCat = [];

        foreach ($xml_cat as $value) {
            $newXmlCat[] = (array)$value;
        }

        $newXmlProd = [];

        foreach ($xml_prod as $value) {
            $newXmlProd[] = (array)$value;
        }

        $arrData = $newXmlProd;

        foreach ($newXmlProd as $key => $value) {
            $arrData[$key]['name'] = $newXmlCat[array_search($value['categoryId'], array_column($newXmlCat, 'id'))]['name'];
        }

        return $arrData;
    }


    /**
     * Метод получает массив имен аттрибутов модели
     *
     * @return array массив имен аттрибутов модели
     */
    public function getNames($data)
    {
        $arrNames = [];
        foreach ($data as $value) {
            $arrNames[$value['name']] = $value['name'];
        }
        return $arrNames;
    }

    /**
     * Метод находит соответствия между переданными параметрами и массивом данных
     *
     * @return array массив данных в которых содержатся соответствующие значения параметров
     */
    public function filter($arrData, $requestParams)
    {
        foreach ($arrData as $key => $item) {
            $result = array_intersect_assoc($requestParams, $item);
            if (!empty($result)) {
                $arrResult[] = $arrData[$key];
            }
        }
        return $arrResult;
    }

}
