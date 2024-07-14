<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%promocodes}}`.
 */
class m240714_194211_create_promocodes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%promocodes}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'code' => $this->string()->notNull()->unique(),
        ]);

        $this->addForeignKey(
            'fk-promocodes-user_id',
            '{{%promocodes}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-promocodes-user_id',
            '{{%promocodes}}'
        );

        $this->dropTable('{{%promocodes}}');
    }
}
