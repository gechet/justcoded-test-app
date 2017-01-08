<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%photo}}".
 *
 * @property integer $id
 * @property string $file
 * @property integer $product_id
 *
 * @property Product $product
 */
class Photo extends \yii\db\ActiveRecord
{
    
    const STORAGE_PATH = '/storage/';
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%photo}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file', 'product_id'], 'required'],
            [['product_id'], 'integer'],
            [['file'], 'string', 'max' => 255],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'file' => 'File',
            'product_id' => 'Product ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
    
    /**
     * Save uploaded photo
     * @param UploadedFile|array $photo
     * @param integer $product Product id
     */
    public static function savePhoto($photo, $product)
    {
        if (!is_array($photo)) {
            $photo = [$photo];
        }
        foreach ($photo as $file) {
            $fileHash = md5_file($file->tempName);
            $folder = Yii::getAlias('@webroot') .  self::STORAGE_PATH;
            if (!file_exists($folder)) {
                mkdir($folder, 0777, true);
            }
            if ($file->saveAs($folder . $fileHash . '.' . $file->extension)) {
                (new self([
                    'file' => $fileHash . '.' . $file->extension,
                    'product_id' => $product,
                ]))->save();
            }
        }
    }
}
