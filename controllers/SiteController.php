<?php

namespace app\controllers;

use app\models\News;
use app\models\Tag;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;

class SiteController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $tag = new Tag();
        return $this->render('index',[
            'tag'=>$tag,
        ]);
    }

    public function actionGetNews(){
        if(Yii::$app->request->isAjax) {
            $name = Yii::$app->request->post('name');
            $name = trim(strip_tags($name));
            $page = Yii::$app->request->post('page');
            $page = intval($page);
            $tag = Tag::getTagByName($name);
            if($tag == null){
                return '';
            }else{
                $dataProvider = new ActiveDataProvider([
                    'query' => $tag->getAllNews(),
                    'pagination' => [
                        'pageSize' => News::PAGE_SIZE,
                    ],
                ]);
                return $this->renderAjax('gridNews', [
                    'dataProvider' => $dataProvider,
                    'page' => $page,
                    'count' => $dataProvider->query->count(),
                ]);
            }
        }
    }
}
