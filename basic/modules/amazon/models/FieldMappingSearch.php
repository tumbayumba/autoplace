<?php

namespace app\modules\amazon\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\amazon\models\FieldMapping;

/**
 * FieldMappingSearch represents the model behind the search form about `app\modules\amazon\models\FieldMapping`.
 */
class FieldMappingSearch extends FieldMapping
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'host_id'], 'integer'],
            [['amz_field', 'pl_field', 'description'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = FieldMapping::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'host_id' => $this->host_id,
        ]);

        $query->andFilterWhere(['like', 'amz_field', $this->amz_field])
            ->andFilterWhere(['like', 'pl_field', $this->pl_field])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
