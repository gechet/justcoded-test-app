<?php

use app\migrations\Migration;

/**
 * Handles the creation of table `product`.
 */
class m170107_114914_create_product_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'qty' => $this->integer()->notNull()->defaultValue(0),
            'price' => $this->money()->notNull(),
            'sale_price' => $this->money(),
            'sale_qty' => $this->integer(),
            'description' => $this->text(),
        ], $this->tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%product}}');
    }
}
