<?php


namespace app\models;

use yii\db\ActiveRecord;
use creocoder\nestedsets\NestedSetsBehavior;
use app\components\TagQuery;

/**
 * Class Tag
 * @package app\models
 * Рубрика, организовано с помощью nested tree
 * @property int $id
 * @property string|null $name
 *
 * @property News[] $news
 */
class Tag extends ActiveRecord
{
    public function behaviors() {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::className(),
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function find()
    {
        return new TagQuery(get_called_class());
    }

    public function getNews(){
        return $this->hasMany(News::className(), ['id' => 'news_id'])
            ->viaTable('news_tag_rel', ['tag_id' => 'id']);
    }

    public function getAllNews(){

    }
}