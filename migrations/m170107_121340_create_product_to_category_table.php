<?php

use app\migrations\Migration;

/**
 * Handles the creation of table `product_to_category`.
 */
class m170107_121340_create_product_to_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%product_to_category}}', [
            'product_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull(),
        ], $this->tableOptions);
        
        $this->createIndex('product_index', '{{%product_to_category}}', 'product_id');
        $this->createIndex('category_index', '{{%product_to_category}}', 'category_id');
        
        $this->addForeignKey('fk_product_relation', '{{%product_to_category}}', 'product_id', '{{%product}}', 'id', 'CASCADE');
        $this->addForeignKey('fk_category_relation', '{{%product_to_category}}', 'category_id', '{{%category}}', 'id', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk_category_relation', '{{%product_to_category}}');
        $this->dropForeignKey('fk_product_relation', '{{%product_to_category}}');
        
        $this->dropIndex('category_index', '{{%product_to_category}}');
        $this->dropIndex('product_index', '{{%product_to_category}}');
        
        $this->dropTable('{{%product_to_category}}');
    }
}
