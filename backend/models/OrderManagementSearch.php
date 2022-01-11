<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\OrderManagement;

/**
 * OrderManagementSearch represents the model behind the search form of `backend\models\OrderManagement`.
 */
class OrderManagementSearch extends OrderManagement
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['orderId', 'userId', 'prouductId', 'orderedQuantity', 'deliveredQuantity'], 'integer'],
            [['orderCode', 'isDelivered', 'status', 'createdAt', 'updatedAt'], 'safe'],
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
        $query = OrderManagement::find();

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
            'orderId' => $this->orderId,
            'userId' => $this->userId,
            'prouductId' => $this->prouductId,
            'orderedQuantity' => $this->orderedQuantity,
            'deliveredQuantity' => $this->deliveredQuantity,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ]);

        $query->andFilterWhere(['like', 'orderCode', $this->orderCode])
            ->andFilterWhere(['like', 'isDelivered', $this->isDelivered])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
