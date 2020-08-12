<?php


namespace app\controllers;


use app\models\Tag;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Response;

class RestController extends Controller
{
    public function beforeAction($action)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return parent::beforeAction($action);
    }

    public function actionGetNews($name){
        $tag = Tag::getTagByName($name);
        if($tag == null){
            return['error'=>'Рубрика не найдена'];
        }else{
            $newsList = $tag->getAllNews()->asArray()->all();
            return $newsList;
        }
    }

    public function actionGetTags($name){
        $tag = Tag::getTagByName($name);
        if($tag == null){
            return['error'=>'Рубрика не найдена'];
        }else{
            return $tag->getAllChildren();
        }
    }
}