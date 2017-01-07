<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $parent_id
 *
 * @property ProductToCategory[] $productToCategories
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['parent_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'parent_id' => 'Parent ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductToCategories()
    {
        return $this->hasMany(ProductToCategory::className(), ['category_id' => 'id']);
    }
    
    public function getPossibleParentCategories()
    {
        return self::getAsArray($this->id);
    }
    
    public static function getAsArray($exclude = null)
    {
        $data = self::find()->select(['id', 'name'])->asArray();
        if ($exclude) {
            $data->andWhere(['not', ['id' => $exclude]]);
        }
        return ArrayHelper::map($data->all(), 'id', 'name');
    }
}
