<?php

namespace app\modules\amazon\models;

use Yii;

/**
 * This is the model class for table "tbl_category_mapping".
 *
 * @property integer $id
 * @property integer $mh_cat_id
 * @property integer $browse_node
 * @property string $mh_desc
 * @property string $amz_desc
 * @property integer $host_id
 * @property integer $fulfillment_latency
 */
class CategoryMapping extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_category_mapping';
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
            [['mh_cat_id'], 'required'],
            [['mh_cat_id', 'browse_node', 'host_id', 'fulfillment_latency'], 'integer'],
            [['mh_desc', 'amz_desc'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mh_cat_id' => 'Mh Cat ID',
            'browse_node' => 'Browse Node',
            'mh_desc' => 'Mh Desc',
            'amz_desc' => 'Amz Desc',
            'host_id' => 'Host ID',
            'fulfillment_latency' => 'Fulfillment Latency',
        ];
    }
}
