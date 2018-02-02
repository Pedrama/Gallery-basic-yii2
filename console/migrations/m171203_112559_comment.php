<?php

use yii\db\Migration;

/**
 * Class m171203_112559_comment
 */
class m171203_112559_comment extends Migration
{

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%comment}}', [
            'id' => $this->primaryKey()->unsigned(),
            'content' => $this->text(),
            'image_id' => $this->integer()->unsigned(),
            'status' => $this->smallInteger()->unsigned(),
            'create_user_id' => $this->integer()->unsigned(),
            'update_user_id' => $this->integer()->unsigned(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),

            'FOREIGN KEY (`image_id`) REFERENCES {{%image}} (`id`) ON DELETE CASCADE ON UPDATE CASCADE',
            'FOREIGN KEY (`create_user_id`) REFERENCES {{%user}} (`id`) ON DELETE CASCADE ON UPDATE CASCADE',
            'FOREIGN KEY (`update_user_id`) REFERENCES {{%user}} (`id`) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);
        $this->createTable('{{%like}}', [
            'id' => $this->primaryKey()->unsigned(),
            'image_id' => $this->integer()->unsigned(),
           'create_user_id' => $this->integer()->unsigned(),
           'created_at' => $this->integer()->notNull(),


            'FOREIGN KEY (`image_id`) REFERENCES {{%image}} (`id`) ON DELETE CASCADE ON UPDATE CASCADE',
            'FOREIGN KEY (`create_user_id`) REFERENCES {{%user}} (`id`) ON DELETE CASCADE ON UPDATE CASCADE',

        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%comment}}');
        $this->dropTable('{{%like}}');
    }

}
