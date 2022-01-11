<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AppContentManagement;

/**
 * AppContentManagementSearch represents the model behind the search form of `backend\models\AppContentManagement`.
 */
class AppContentManagementSearch extends AppContentManagement
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['autoId'], 'integer'],
            [['contentKey', 'contentValue', 'createdAt', 'updatedAt'], 'safe'],
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
        $query = AppContentManagement::find();

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
            'autoId' => $this->autoId,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ]);

        $query->andFilterWhere(['like', 'contentKey', $this->contentKey])
            ->andFilterWhere(['like', 'contentValue', $this->contentValue]);

        return $dataProvider;
    }
}
