<?php

use yii\db\Migration;

/**
 * Handles the creation of table `categories`.
 */
class m180406_175712_create_categories_table extends Migration
{
    public const TABLE_NAME = '{{%categories}}';

    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->comment('Наименование'),
            'slug' => $this->string()->notNull()->comment('Slug'),
            'title' => $this->string()->comment('Заголовок'),
            'description' => $this->text()->comment('Описание'),
            'meta_json' => $this->text()->comment('Meta'),
            'lft' => $this->integer()->notNull()->comment('Левые'),
            'rgt' => $this->integer()->notNull()->comment('Правые'),
            'depth' => $this->integer()->notNull()->comment('Глубина'),
        ], $tableOptions);

        $this->createIndex('{{%idx-categories-slug}}', self::TABLE_NAME, 'slug', true);

        $this->insert(self::TABLE_NAME, [
            'id' => 1,
            'name' => '',
            'slug' => 'root',
            'title' => null,
            'description' => null,
            'meta_json' => '{}',
            'lft' => 1,
            'rgt' => 2,
            'depth' => 0,
        ]);
    }

    public function safeDown()
    {
        $this->dropTable(self::TABLE_NAME);
    }
}
