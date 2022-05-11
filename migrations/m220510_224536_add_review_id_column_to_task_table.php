<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%task}}`.
 */
class m220510_224536_add_review_id_column_to_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->addColumn('task', 'review_id', $this->integer()->unique());
        $this->addForeignKey(
            'fk-review_id',
            'task',
            'review_id',
            'review',
            'id'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
