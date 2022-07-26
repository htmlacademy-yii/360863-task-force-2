<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%task_file}}`.
 */
class m220716_202827_add_size_column_to_task_file_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('task_file', 'size', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('task_file', 'size');
    }
}
