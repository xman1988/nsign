<?php


namespace app\controllers;

use app\models\Xml;
use Yii;
use yii\base\Controller;
use yii\data\ArrayDataProvider;
use yii\helpers\StringHelper;


/**
 * Класс XmlController
 * Читает Xml файлы, создает DataProvider, отдает DataProvider во view.
 *
 *
 * @package app\controllers
 */
class XmlController extends Controller
{

    public function actionIndex()
    {
        $model = new Xml();

        // Получаем все данные из XML файлов
        $data = $model->getXmlData();

        // Получаем названия атрибутов для выпадающего списка во view
        $arrNames = $model->getNames($data);

        // Получаем имя модели
        $modelClassName = StringHelper::basename(get_class($model));

        $getParams = Yii::$app->request->get();

        // Убираем из GET параметров пустые значения
        if (is_array($getParams[$modelClassName])) {
            $getParams[$modelClassName] = array_diff($getParams[$modelClassName], ['']);
        }

        // Если переданы параметры для фильтрации данных, то делаем выборку из XML данных
        if (!empty($getParams[$modelClassName])) {
            $data = $model->filter($data, $getParams[$modelClassName]);
        }

        // Создаем провайдер данных, устанавливаем пагинацию, сортируем колонки
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'attributes' => ['id', 'name', 'price'],
                'defaultOrder' => [
                    'id' => SORT_ASC,
                    'name' => SORT_ASC,
                    'price' => SORT_DESC,
                ],
            ],
        ]);

        // Передаем провайдер данных, модель для фильтрации, имена атрибутов для выпадающего списка
        return $this->render('table',
            [
                'dataProvider' => $dataProvider,
                'filterModel' => $model,
                'names' => $arrNames,
            ]
        );


    }

}
