<?php

use yii\grid\GridView;

?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'layout' => "{items}\n{summary}\n{pager}",
    'columns' => [
        'title',
        'tagList',
    ],
]); ?>
