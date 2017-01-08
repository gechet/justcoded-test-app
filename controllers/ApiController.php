<?php

namespace app\controllers;

use Yii;
use app\models\Product;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;

class ApiController extends \yii\rest\Controller
{   
    
    public function actionGetProductDetails($product_id)
    {
        $product = Product::findOne($product_id);
        if (!$product) {
            throw new NotFoundHttpException;
        }
        return $product;
    }

}
