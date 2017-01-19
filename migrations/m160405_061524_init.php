<?php

use yii\db\Migration;

class m160405_061524_init extends Migration
{
    const TABLE_NAME = 'comments';
    const TABLE = '{{%' . self::TABLE_NAME . '}}';

    public function up()
    {
        $this->createTable(self::TABLE, [
            'id' => $this->primaryKey()->unsigned() . ' AUTO_INCREMENT PRIMARY KEY',
            'item_type' => $this->smallInteger(1)->unsigned()->notNull(),
            'item_id' => $this->integer()->notNull()->unsigned(),
            'user_id' => $this->integer()->notNull()->unsigned(),
            'parent_id' => $this->integer()->unsigned(),
            'text' => $this->text()->notNull(),
            'status' => $this->smallInteger(1)->unsigned()->notNull(),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned()
        ]);

        $this->createIndex(self::TABLE_NAME . '_item_type_index', self::TABLE, 'item_type');
        $this->createIndex(self::TABLE_NAME . '_item_id_index', self::TABLE, 'item_id');
        $this->createIndex(self::TABLE_NAME . '_status_index', self::TABLE, 'status');
        $this->addForeignKey(self::TABLE_NAME . '_parent_id_fk', self::TABLE, 'parent_id', self::TABLE, 'id', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable(self::TABLE);
    }
}
