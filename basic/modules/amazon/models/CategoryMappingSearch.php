<?php

namespace app\modules\amazon\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\amazon\models\CategoryMapping;

/**
 * CategoryMappingSearch represents the model behind the search form about `app\modules\amazon\models\CategoryMapping`.
 */
class CategoryMappingSearch extends CategoryMapping
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'mh_cat_id', 'browse_node', 'host_id', 'fulfillment_latency'], 'integer'],
            [['mh_desc', 'amz_desc'], 'safe'],
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
        $query = CategoryMapping::find();

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
            'mh_cat_id' => $this->mh_cat_id,
            'browse_node' => $this->browse_node,
            'host_id' => $this->host_id,
            'fulfillment_latency' => $this->fulfillment_latency,
        ]);

        $query->andFilterWhere(['like', 'mh_desc', $this->mh_desc])
            ->andFilterWhere(['like', 'amz_desc', $this->amz_desc]);

        return $dataProvider;
    }
}
