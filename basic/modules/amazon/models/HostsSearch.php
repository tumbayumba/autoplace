<?php

namespace app\modules\amazon\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\amazon\models\Hosts;

/**
 * HostsSearch represents the model behind the search form about `app\modules\amazon\models\Hosts`.
 */
class HostsSearch extends Hosts
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['id', 'integer'],
            [['sku_prefix', 'external_product_id_type', 'brand_name', 'manufacturer', 'currency', 'lang', 'feed_product_type'], 'safe'],
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
        $query = Hosts::find();

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
        ]);

        $query->andFilterWhere(['like', 'sku_prefix', $this->sku_prefix])
            ->andFilterWhere(['like', 'external_product_id_type', $this->external_product_id_type])
            ->andFilterWhere(['like', 'brand_name', $this->brand_name])
            ->andFilterWhere(['like', 'manufacturer', $this->manufacturer])
            ->andFilterWhere(['like', 'currency', $this->currency])
            ->andFilterWhere(['like', 'lang', $this->lang])
            ->andFilterWhere(['like', 'feed_product_type', $this->feed_product_type]);

        return $dataProvider;
    }
}
