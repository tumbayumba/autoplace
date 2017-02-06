<?php

namespace app\modules\amazon\models;

use Yii;

/**
 * This is the model class for table "{{%hosts}}".
 *
 * @property integer $id
 * @property string $sku_prefix
 * @property string $external_product_id_type
 * @property string $brand_name
 * @property string $manufacturer
 * @property string $currency
 * @property string $lang
 * @property string $feed_product_type
 */
class Hosts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%hosts}}';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db1');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['sku_prefix', 'required'],
            [['sku_prefix', 'external_product_id_type', 'brand_name', 'manufacturer', 'currency', 'lang', 'feed_product_type', 'alias'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sku_prefix' => 'Sku Prefix',
            'external_product_id_type' => 'External Product Id Type',
            'brand_name' => 'Brand Name',
            'manufacturer' => 'Manufacturer',
            'currency' => 'Currency',
            'lang' => 'Lang',
            'feed_product_type' => 'Feed Product Type',
            'alias' => 'Alias',
        ];
    }
}
