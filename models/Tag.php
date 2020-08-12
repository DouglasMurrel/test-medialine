<?php


namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use creocoder\nestedsets\NestedSetsBehavior;
use app\components\TagQuery;
use yii\helpers\ArrayHelper;

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
    /**
     * @return array
     */
    public function behaviors() {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::className(),
            ],
        ];
    }

    /**
     * @return array
     */
    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tag';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Рубрика',
        ];
    }

    /**
     * @return TagQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new TagQuery(get_called_class());
    }


    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getNews(){
        return $this->hasMany(News::className(), ['id' => 'news_id'])
            ->viaTable('news_tag_rel', ['tag_id' => 'id']);
    }

    /**
     * Получаем список id самой рубрики+всех дочерних рубрик
     * @return array
     */
    private function getAllChildrenIds(){
        $idList = [];
        $idList[] = $this->id;
        $children = $this->children()->all();
        foreach($children as $child)$idList[] = $child->id;
        return $idList;
    }

    /**
     * Получаем список новостей, связанных с данной рубрикой и дочерними.
     * Возвращваем ActiveQuery, потому что будем использовать в том числе как DataProvider
     * @return \yii\db\ActiveQuery
     */
    public function getAllNews(){
        $idList = $this->getAllChildrenIds();
        $newsListQuery = News::find()
            ->select('n.*')
            ->from('news n')
            ->innerJoin('news_tag_rel r','n.id=r.news_id')
            ->where('r.tag_id in ('.implode(',',$idList).')');
        return $newsListQuery;
    }

    /**
     * @return array
     */
    public function getAllChildren(){
        $tagList = $this->children()->all();
        $tagList = ArrayHelper::getColumn($tagList, function ($element) {
            return ['id'=>$element['id'],'name'=>$element['name']];
        });
        return $tagList;
    }

    /**
     * @param $name
     * @return array|ActiveRecord|null
     */
    public static function getTagByName($name){
        return Tag::find()->where(['like','name',$name,false])->one();
    }
}