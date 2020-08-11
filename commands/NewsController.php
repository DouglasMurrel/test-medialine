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

        $tag_root = new Tag(['name' => 'Все новости']);
        $tag_root->makeRoot();

        $tag_society = new Tag(['name' => 'Общество']);
        $tag_society->appendTo($tag_root);

        $tag_sport = new Tag(['name' => 'Спорт']);
        $tag_sport->appendTo($tag_root);

        $tag_science = new Tag(['name' => 'Наука']);
        $tag_science->appendTo($tag_root);

        $tag_election = new Tag(['name'=>'Выборы']);
        $tag_election->appendTo($tag_society);

        $tag_meeting = new Tag(['name'=>'Митинг']);
        $tag_meeting->appendTo($tag_society);

        $tag_soccer = new Tag(['name'=>'Футбол']);
        $tag_soccer->appendTo($tag_sport);

        $tag_chess = new Tag(['name'=>'Шахматы']);
        $tag_chess->appendTo($tag_sport);

        $tag_math = new Tag(['name'=>'Математика']);
        $tag_math->appendTo($tag_science);

        $tag_physics = new Tag(['name'=>'Физика']);
        $tag_physics->appendTo($tag_science);

        for($i=0;$i<10;$i++){
            $news = new News();
            $news->title = "Новость $i";
            $news->content = "Текст новости $i";
            $news->save();

            if($i==0){
                $news->link('tags',$tag_society);
                $news->link('tags',$tag_math);
            }
            if($i==1){
                $news->link('tags',$tag_society);
                $news->link('tags',$tag_election);
            }
            if($i==2){
                $news->link('tags',$tag_sport);
                $news->link('tags',$tag_physics);
            }
            if($i==3){
                $news->link('tags',$tag_chess);
                $news->link('tags',$tag_soccer);
            }
            if($i==4){
                $news->link('tags',$tag_meeting);
                $news->link('tags',$tag_science);
            }
            if($i==5){
                $news->link('tags',$tag_physics);
                $news->link('tags',$tag_society);
            }
            if($i==6){
                $news->link('tags',$tag_math);
                $news->link('tags',$tag_election);
            }
            if($i==7){
                $news->link('tags',$tag_society);
                $news->link('tags',$tag_meeting);
            }
            if($i==8){
                $news->link('tags',$tag_chess);
                $news->link('tags',$tag_election);
            }
            if($i==9){
                $news->link('tags',$tag_society);
                $news->link('tags',$tag_soccer);
            }
        }

        return ExitCode::OK;
    }
}
