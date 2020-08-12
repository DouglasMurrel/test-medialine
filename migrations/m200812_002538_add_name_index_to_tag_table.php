<?php

use yii\db\Migration;

/**
 * Class m200812_002538_add_name_index_to_tag_table
 */
class m200812_002538_add_name_index_to_tag_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('name','tag','name');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('name','tag');
    }

}
