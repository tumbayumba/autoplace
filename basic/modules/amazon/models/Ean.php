<?php

namespace app\modules\amazon\models;

use Yii;

/**
 * This is the model class for table "tbl_ean".
 *
 * @property integer $id
 * @property string $ean
 * @property integer $status
 */
class Ean extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_ean';
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
            [['ean'], 'required'],
            [['status'], 'integer'],
            [['ean'], 'string', 'max' => 45],
            [['ean'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ean' => 'Ean',
            'status' => 'Status',
        ];
    }
}
