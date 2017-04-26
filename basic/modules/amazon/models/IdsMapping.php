<?php

namespace app\modules\amazon\models;

use Yii;

/**
 * This is the model class for table "{{%ids_mapping}}".
 *
 * @property string $id
 * @property string $product_id
 * @property string $sku
 * @property string $asin
 * @property integer $host_id
 */
class IdsMapping extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%ids_mapping}}';
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
            [['product_id'], 'required'],
            [['product_id', 'host_id'], 'integer'],
            [['sku', 'asin'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'sku' => 'Sku',
            'asin' => 'Asin',
            'host_id' => 'Host ID',
        ];
    }
}
