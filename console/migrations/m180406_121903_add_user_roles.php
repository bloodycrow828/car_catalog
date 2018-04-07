<?php

use yii\db\Migration;

/**
 * Class m180406_121903_add_user_roles
 */
class m180406_121903_add_user_roles extends Migration
{
    public function safeUp()
    {
        $this->batchInsert('{{%auth_items}}', ['type', 'name', 'description'], [
            [1, 'user', 'User'],
            [1, 'admin', 'Admin'],
        ]);

        $this->batchInsert('{{%auth_item_children}}', ['parent', 'child'], [
            ['admin', 'user'],
        ]);

        $this->insert('{{%users}}',[
            'username' => 'adm',
            'auth_key' => 'OMEKCqtDQOdQ2OWpgiKRWYyzzne',
            'password_hash' => '$2y$13$nJ1WDlBaGcbCdbNC5.5l4.sgy.OMEKCqtDQOdQ2OWpgiKRWYyzzne',
            'password_reset_token' => '',
            'created_at' => '1523020198',
            'updated_at' => '1523020198',
            'email' => 'user@user.info',
        ]);

        $this->execute("INSERT INTO {{%auth_assignments}} (item_name, user_id) SELECT 'admin', u.id FROM {{%users}} u ORDER BY u.id");
    }

    public function down()
    {
        $this->delete('{{%auth_items}}', ['name' => ['user', 'admin']]);
    }
}
