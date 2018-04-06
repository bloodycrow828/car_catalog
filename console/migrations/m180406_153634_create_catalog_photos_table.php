<?php

use yii\db\Migration;

/**
 * Handles the creation of table `catalog_photos`.
 */
class m180406_153634_create_catalog_photos_table extends Migration
{
    public const TABLE_NAME = '{{%catalog_photos}}';

    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB COMMENT="Изображения"';

        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'car_id' => $this->integer()->unsigned()->notNull()->comment('ИД автомобиля'),
            'file' => $this->string()->notNull()->comment('Имя файла'),
        ], $tableOptions);

        $this->createIndex('{{%idx-catalog_photos-car_id}}', self::TABLE_NAME, 'car_id');

        $this->addForeignKey('{{%fk-catalog_photos-car_id}}', self::TABLE_NAME, 'car_id',
            '{{%car}}', 'id', 'CASCADE', 'RESTRICT');
    }

    public function safeDown()
    {
        $this->dropTable(self::TABLE_NAME);
    }
}
