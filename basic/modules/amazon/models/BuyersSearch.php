<?php

namespace app\modules\amazon\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\amazon\models\Buyers;

/**
 * BuyersSearch represents the model behind the search form about `app\modules\amazon\models\Buyers`.
 */
class BuyersSearch extends Buyers
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['buyer_name', 'email', 'country', 'item_id', 'title', 'price', 'sale_date', 'sku', 'source', 'link', 'description'], 'safe'],
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
        $query = Buyers::find();

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

        $query->andFilterWhere(['like', 'buyer_name', $this->buyer_name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'country', $this->country])
            ->andFilterWhere(['like', 'item_id', $this->item_id])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'price', $this->price])
            ->andFilterWhere(['like', 'sale_date', $this->sale_date])
            ->andFilterWhere(['like', 'sku', $this->sku])
            ->andFilterWhere(['like', 'source', $this->source])
            ->andFilterWhere(['like', 'link', $this->link])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
