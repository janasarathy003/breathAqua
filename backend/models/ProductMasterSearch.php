<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ProductMaster;

/**
 * ProductMasterSearch represents the model behind the search form of `backend\models\ProductMaster`.
 */
class ProductMasterSearch extends ProductMaster
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['productId', 'capacityId', 'brandId'], 'integer'],
            [['productName', 'capacity', 'brandName', 'status', 'createdAt', 'updatedAt'], 'safe'],
            [['basePrice', 'halfPrice'], 'number'],
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
        $query = ProductMaster::find();

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
            'productId' => $this->productId,
            'capacityId' => $this->capacityId,
            'brandId' => $this->brandId,
            'basePrice' => $this->basePrice,
            'halfPrice' => $this->halfPrice,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ]);

        $query->andFilterWhere(['like', 'productName', $this->productName])
            ->andFilterWhere(['like', 'capacity', $this->capacity])
            ->andFilterWhere(['like', 'brandName', $this->brandName])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
