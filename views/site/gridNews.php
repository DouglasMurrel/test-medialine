<?php

use app\components\GridView;
use app\models\News;

$dataProvider->pagination->pageSize += $page * News::PAGE_SIZE;
?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'layout' => "{items}\n{summary}",
    'columns' => [
        'title',
        'tagList',
    ],
]); ?>
<?
if($dataProvider->pagination->getOffset()+$dataProvider->pagination->getPageSize()<$count){
?>
<a href="" onclick="show_more();return false;">Показать еще</a>
<?}?>
<input type="hidden" id="page" value="-1">