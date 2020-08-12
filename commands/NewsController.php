<?php

namespace app\commands;

use app\models\News;
use app\models\Tag;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;

class NewsController extends Controller
{
    public function actionFillDb()
    {
        Yii::$app->db->createCommand("SET foreign_key_checks = 0")->execute();
        Yii::$app->db->createCommand()->truncateTable('tag')->execute();
        Yii::$app->db->createCommand()->truncateTable('news')->execute();
        Yii::$app->db->createCommand()->truncateTable('news_tag_rel')->execute();
        Yii::$app->db->createCommand("SET foreign_key_checks = 1")->execute();

        $arrTag = [];

        $tag_root = new Tag(['name' => 'Все новости']);
        $tag_root->makeRoot();
        $arrTag[] = ['tag'=>$tag_root,'news'=>[7,8]];

        $tag_society = new Tag(['name' => 'Общество']);
        $tag_society->appendTo($tag_root);
        $arrTag[] = ['tag'=>$tag_society,'news'=>[7,4]];

        $tag_sport = new Tag(['name' => 'Спорт']);
        $tag_sport->appendTo($tag_root);
        $arrTag[] = ['tag'=>$tag_sport,'news'=>[2,9]];

        $tag_science = new Tag(['name' => 'Наука']);
        $tag_science->appendTo($tag_root);
        $arrTag[] = ['tag'=>$tag_science,'news'=>[6,7]];

        $tag_election = new Tag(['name'=>'Выборы']);
        $tag_election->appendTo($tag_society);
        $arrTag[] = ['tag'=>$tag_election,'news'=>[5,3]];

        $tag_meeting = new Tag(['name'=>'Митинг']);
        $tag_meeting->appendTo($tag_society);
        $arrTag[] = ['tag'=>$tag_meeting,'news'=>[9,1]];

        $tag_soccer = new Tag(['name'=>'Футбол']);
        $tag_soccer->appendTo($tag_sport);
        $arrTag[] = ['tag'=>$tag_soccer,'news'=>[8,4]];

        $tag_chess = new Tag(['name'=>'Шахматы']);
        $tag_chess->appendTo($tag_sport);
        $arrTag[] = ['tag'=>$tag_chess,'news'=>[1,5]];

        $tag_math = new Tag(['name'=>'Математика']);
        $tag_math->appendTo($tag_science);
        $arrTag[] = ['tag'=>$tag_math,'news'=>[7,4]];

        $tag_physics = new Tag(['name'=>'Физика']);
        $tag_physics->appendTo($tag_science);
        $arrTag[] = ['tag'=>$tag_physics,'news'=>[1,6]];

        for($i=0;$i<10;$i++){
            $news = new News();
            $news->title = "Новость $i";
            $newsArr = $arrTag[$i]['news'];
            $tag1 = $arrTag[$newsArr[0]]['tag'];
            $tag2 = $arrTag[$newsArr[1]]['tag'];
            $news->content = $tag1->name.','.$tag2->name;
            $news->save();
            $news->link('tags', $tag1);
            $news->link('tags', $tag2);
        }

        return ExitCode::OK;
    }
}
