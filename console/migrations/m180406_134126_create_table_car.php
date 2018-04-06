<?php

use yii\db\Migration;

/**
 * Class m180406_134126_create_table_car
 */
class m180406_134126_create_table_car extends Migration
{
    public const TABLE_NAME = '{{%car}}';

    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB COMMENT="Автомобили"';

        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey()->unsigned()->comment('Id'),
            'category_id' => $this->smallInteger(3)->comment('id модельного ряда'),
            'title' => $this->string(255)->comment('Название'),
            'image' => $this->string(255)->comment('Изображение'),
            'price' => $this->integer(11)->comment('Цена'),
            'url' => $this->string(255)->comment('ссылка на страницу'),
            'date' => $this->integer(11)->comment('дата выпуска в формате timestump'),
            'created_at' => $this->integer(11)->notNull()->comment('дата создания'),
            'updated_at' => $this->integer(11)->notNull()->comment('дата обновления'),
            'status' => $this->smallInteger(2)->comment('Статус'),

        ], $tableOptions);

        $this->createIndex('url', self::TABLE_NAME, 'url', true);
    }

    public function safeDown()
    {
        $this->dropTable(self::TABLE_NAME);
    }
}
