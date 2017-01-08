<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;

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
     * Array of uploaded files
     * @var mixed 
     */
    public $photo;

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
            ['photo', 'file', 'maxFiles' => 0],
        ];
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
        if ($this->photo) {
            Photo::savePhoto($this->photo, $this->id);
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
     * Returns array of products images
     * @param boolean $absolute
     * @return array
     */
    public function getPhotoUrls($absolute = true)
    {
        if ($this->photos) {
            return array_map(function ($file) use ($absolute) {
                $url = '';
                if ($absolute) {
                    $url .= Url::base(true);
                }
                $url .= Photo::STORAGE_PATH . $file;
                return $file;
            }, ArrayHelper::getColumn($this->photos, 'file'));
        }
        return [];
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
    
    /**
     * Format row with links to connected categories
     * @return string
     */
    public function getCategoryRow()
    {
        $row = [];
        if ($this->categories) {
            foreach ($this->categories as $category) {
                $row[] = Html::a($category->name, ['/category/view', 'id' => $category->id]);
            }
        }
        return implode(', ', $row);
    }
}
