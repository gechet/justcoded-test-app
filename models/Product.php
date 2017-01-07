<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%product}}".
 *
 * @property integer $id
 * @property string $title
 * @property integer $qty
 * @property string $price
 * @property string $sale_price
 * @property integer $sale_qty
 * @property string $description
 *
 * @property Photo[] $photos
 * @property Category[] $categories
 * @property ProductToCategory[] $productToCategories
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * Array of selected categories
     * @var array
     */
    public $category;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'price'], 'required'],
            [['qty', 'sale_qty'], 'integer'],
            [['price', 'sale_price'], 'number'],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 255],
            ['category', 'each', 'rule' => ['integer']],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }
    
    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        if ($this->category) {
            ProductToCategory::deleteAll(['product_id' => $this->id]);
            foreach ($this->category as $categoryId) {
                (new ProductToCategory([
                    'product_id' => $this->id, 
                    'category_id' => $categoryId
                ]))->save();
            }
        }
        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'qty' => 'Qty',
            'price' => 'Price',
            'sale_price' => 'Sale Price',
            'sale_qty' => 'Sale Qty',
            'description' => 'Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPhotos()
    {
        return $this->hasMany(Photo::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductToCategories()
    {
        return $this->hasMany(ProductToCategory::className(), ['product_id' => 'id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['id' => 'category_id'])->via('productToCategories');
    }
}
