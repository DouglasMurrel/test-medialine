<?php

namespace app\models;

use Yii;

/**
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $content
 *
 * @property Tag[] $tags
 */
class News extends \yii\db\ActiveRecord
{
    const PAGE_SIZE = 20;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'content' => 'Текст',
            'tagList' => 'Рубрики',
        ];
    }


    /**
     * Получает список привязанных рубрик
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->viaTable('news_tag_rel', ['news_id' => 'id']);
    }

    public function getTagList(){
        $tags = $this->tags;
        $result = [];
        foreach($tags as $tag){
            $result[] = $tag->name;
        }
        return implode(', ',$result);
    }
}
