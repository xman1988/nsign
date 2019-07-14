<?php

use yii\grid\GridView;

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $filterModel,
    'columns' => [
        [
            'class' => 'yii\grid\SerialColumn',
            'header' => '№'
        ],

        [
            'attribute' => 'id',
            'filter' => false,
        ],

        [
            'attribute' => 'categoryId',
            'visible' => false,
        ],

        [
            'label' => 'Название',
            'attribute' => 'name',
            'format' => 'text',
            'filter' => $names,
            'value' => function ($model) {
                return trim($model['name']);
            }
        ],
        [
            'label' => 'Цена',
            'attribute' => 'price',
        ],
    ]
]);

