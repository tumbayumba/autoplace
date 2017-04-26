<?php

namespace app\modules\amazon\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\amazon\models\IdsMapping;

/**
 * IdsMappingSearch represents the model behind the search form about `app\modules\amazon\models\IdsMapping`.
 */
class IdsMappingSearch extends IdsMapping
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'product_id', 'host_id'], 'integer'],
            [['sku', 'asin'], 'safe'],
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
        $query = IdsMapping::find();

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
            'product_id' => $this->product_id,
            'host_id' => $this->host_id,
        ]);

        $query->andFilterWhere(['like', 'sku', $this->sku])
            ->andFilterWhere(['like', 'asin', $this->asin]);

        return $dataProvider;
    }
}
