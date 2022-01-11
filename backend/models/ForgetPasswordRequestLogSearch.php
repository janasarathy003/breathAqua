<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ForgetPasswordRequestLog;

/**
 * ForgetPasswordRequestLogSearch represents the model behind the search form of `backend\models\ForgetPasswordRequestLog`.
 */
class ForgetPasswordRequestLogSearch extends ForgetPasswordRequestLog
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['autoId', 'referenceId'], 'integer'],
            [['requestType', 'mailId', 'status', 'createdAt', 'updatedAt', 'updatedIpAddress'], 'safe'],
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
        $query = ForgetPasswordRequestLog::find();

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
            'referenceId' => $this->referenceId,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ]);

        $query->andFilterWhere(['like', 'requestType', $this->requestType])
            ->andFilterWhere(['like', 'mailId', $this->mailId])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'updatedIpAddress', $this->updatedIpAddress]);

        return $dataProvider;
    }
}
