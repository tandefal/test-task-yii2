<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%message}}`.
 */
class m231124_085353_create_message_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%message}}', [
            'id' => $this->primaryKey(),
            'type_id' => $this->integer()->notNull(),
            'name' => $this->string(255)->notNull(),
            'email' => $this->string(255)->notNull(),
            'phone' => $this->string(255)->notNull(),
            'content' => $this->text()->notNull(),
            'created_at' => $this->dateTime()->notNull(),
        ]);

        $this->createIndex(
            'idx-message-type_id',
            'message',
            'type_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx-message-type_id', 'message');
        $this->dropTable('{{%message}}');
    }
}
