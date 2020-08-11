<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%news}}`.
 */
class m200811_173641_create_news_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%news}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'content' => $this->text(),
        ]);
        $this->createTable('{{%news_tag_rel%}}', [
            'news_id' => $this->integer(),
            'tag_id' => $this->integer(),
        ]);
        $this->addForeignKey('news_id','news_tag_rel', 'news_id', 'news', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('tag_id','news_tag_rel', 'tag_id', 'tag', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%news_tag_rel}}');
        $this->dropTable('{{%news}}');
    }
}
