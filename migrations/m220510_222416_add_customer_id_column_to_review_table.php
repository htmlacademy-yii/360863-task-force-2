<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%review}}`.
 */
class m220510_222416_add_customer_id_column_to_review_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->addColumn('review', 'worker_id', $this->integer());
        $this->addColumn('review', 'customer_id', $this->integer());
        $this->addForeignKey(
            'user-worker_id',
            'review',
            'worker_id',
            'user',
            'id'
        );
        $this->addForeignKey(
            'user-customer_id',
            'review',
            'customer_id',
            'user',
            'id'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('review', 'worker_id');
        $this->dropColumn('review', 'customer_id');
    }
}
