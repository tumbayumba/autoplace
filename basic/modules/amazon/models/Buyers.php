<?php

namespace app\modules\amazon\models;

use Yii;

/**
 * This is the model class for table "{{%buyers}}".
 *
 * @property string $id
 * @property string $buyer_name
 * @property string $email
 * @property string $country
 * @property string $item_id
 * @property string $title
 * @property string $price
 * @property string $sale_date
 * @property string $sku
 * @property string $source
 * @property string $link
 * @property string $description
 */
class Buyers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%buyers}}';
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
            [['item_id', 'link', 'description'], 'string'],
            [['buyer_name'], 'string', 'max' => 255],
            [['email', 'country', 'title', 'price', 'sale_date', 'sku', 'source'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'buyer_name' => 'Buyer Name',
            'email' => 'Email',
            'country' => 'Country',
            'item_id' => 'Item ID',
            'title' => 'Title',
            'price' => 'Price',
            'sale_date' => 'Sale Date',
            'sku' => 'Sku',
            'source' => 'Source',
            'link' => 'Link',
            'description' => 'Description',
        ];
    }
}
