<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\BrandMaster;

/**
 * BrandMasterSearch represents the model behind the search form of `backend\models\BrandMaster`.
 */
class BrandMasterSearch extends BrandMaster
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['brandId'], 'integer'],
            [['brandName', 'status', 'createdAt', 'updatedAt'], 'safe'],
            [['mrp', 'halfPrice'], 'number'],
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
        $query = BrandMaster::find();

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
            'brandId' => $this->brandId,
            'mrp' => $this->mrp,
            'halfPrice' => $this->halfPrice,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ]);

        $query->andFilterWhere(['like', 'brandName', $this->brandName])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
