<?php


namespace app\components;


use yii\bootstrap4\LinkPager;

class GridView extends \yii\grid\GridView
{
    public function __construct($config = [])
    {
        parent::__construct($config);
    }

    public function renderPager()
    {
        $pagination = $this->dataProvider->getPagination();
        return LinkPager::widget([
            'pagination' => $pagination
        ]);
    }
}