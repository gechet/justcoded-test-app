<?php

use app\migrations\Migration;

/**
 * Handles the creation of table `photo`.
 */
class m170107_122025_create_photo_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%photo}}', [
            'id' => $this->primaryKey(),
            'file' => $this->string()->notNull(),
            'product_id' => $this->integer()->notNull(),
        ], $this->tableOptions);
        
        $this->createIndex('product_photo', '{{%photo}}', 'product_id');
        $this->addForeignKey('fk_product_photo', '{{%photo}}', 'product_id', '{{%product}}', 'id', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk_product_photo', '{{%photo}}');
        $this->dropIndex('product_photo', '{{%photo}}');
        
        $this->dropTable('{{%photo}}');
    }
}
