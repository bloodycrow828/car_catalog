<?php

use yii\db\Migration;

/**
 * Handles the creation of table `category_assignments`.
 */
class m180406_180245_create_category_assignments_table extends Migration
{
    public const TABLE_NAME = '{{%category_assignments}}';
    
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable(self::TABLE_NAME, [
            'car_id' => $this->integer()->unsigned()->notNull(),
            'category_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('{{%pk-category_assignments}}', self::TABLE_NAME, ['car_id', 'category_id']);

        $this->createIndex('{{%idx-category_assignments-car_id}}', self::TABLE_NAME, 'car_id');

        $this->createIndex('{{%idx-category_assignments-category_id}}', self::TABLE_NAME, 'category_id');

        $this->addForeignKey('{{%fk-category_assignments-car_id}}',
            self::TABLE_NAME, 'car_id',
            '{{%car}}', 'id', 'CASCADE', 'RESTRICT');

        $this->addForeignKey('{{%fk-category_assignments-category_id}}',
            self::TABLE_NAME, 'category_id',
            '{{%categories}}', 'id', 'CASCADE', 'RESTRICT');
    }

    public function safeDown()
    {
        $this->dropTable(self::TABLE_NAME);
    }
}
