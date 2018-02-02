<?php

use yii\db\Migration;

/**
 * Class m171115_052153_Albume
 */
class m171115_052153_Albume extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%album}}',[
            'id' => $this->primaryKey(11)->unsigned(),
            'name' => $this->string()->notNull(),
            'parent_id' =>$this->integer()->unsigned(),
            'cover_image_id' =>$this->integer()->unsigned(),
            'create_user_id' => $this->integer()->unsigned(),
            'update_user_id' => $this->integer()->unsigned(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer(),
            'FOREIGN KEY (`parent_id`) REFERENCES {{%album}} (`id`) ON DELETE CASCADE ON UPDATE CASCADE',
            'FOREIGN KEY (`create_user_id`) REFERENCES {{%user}} (`id`) ON DELETE CASCADE ON UPDATE CASCADE',
            'FOREIGN KEY (`update_user_id`) REFERENCES {{%user}} (`id`) ON DELETE CASCADE ON UPDATE CASCADE',
        ],$tableOptions);

        $this->createTable('{{%image}}',[
            'id' => $this->primaryKey(11)->unsigned(),
            'name' => $this->string()->notNull(),
            'album_id' =>$this->integer()->unsigned(),
            'create_user_id' => $this->integer()->unsigned(),
            'update_user_id' => $this->integer()->unsigned(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer(),
            'FOREIGN KEY (`album_id`) REFERENCES {{%album}} (`id`) ON DELETE CASCADE ON UPDATE CASCADE',
            'FOREIGN KEY (`create_user_id`) REFERENCES {{%user}} (`id`) ON DELETE CASCADE ON UPDATE CASCADE',
            'FOREIGN KEY (`update_user_id`) REFERENCES {{%user}} (`id`) ON DELETE CASCADE ON UPDATE CASCADE',
        ],$tableOptions);

        $this->addForeignKey('fk_album_image_cover_image_id','{{%album}}','cover_image_id',
            '{{%image}}','id');

    }

    public function down()
    {
        $this->dropForeignKey('fk_album_image_cover_image_id','{{%album}}');
        $this->dropTable('{{%image}}');
        $this->dropTable('{{%album}}');

    }

}
