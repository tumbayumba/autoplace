<?php

namespace app\modules\amazon\models;

use Yii;

/**
 * This is the model class for table "tbl_field_mapping".
 *
 * @property integer $id
 * @property integer $host_id
 * @property string $amz_field
 * @property string $pl_field
 * @property string $description
 */
class FieldMapping extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_field_mapping';
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
            [['host_id'], 'required'],
            [['host_id'], 'integer'],
            [['description'], 'string'],
            [['amz_field', 'pl_field'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'host_id' => 'Host ID',
            'amz_field' => 'Amz Field',
            'pl_field' => 'Pl Field',
            'description' => 'Description',
        ];
    }
}
