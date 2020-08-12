<?php

/* @var $this yii\web\View */

use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = 'My Yii Application';
?>
<script src="/js/get_news.js"></script>
<div class="site-index">

    <div class="body-content">

        <div class="row">
<?$form = ActiveForm::begin(['action'=>Url::to(['site/get-news']),'id'=>'mainform','options'=>['class'=>'w-100']])?>
<?=$form->field($tag,'name')->input('text',['oninput'=>'get_news(this.value)'])?>
<?ActiveForm::end();?>
        </div>
        <div id="grid"></div>
    </div>
</div>
