<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\CompanyUsersList;

/**
 * CompanyUsersListSearch represents the model behind the search form of `backend\models\CompanyUsersList`.
 */
class CompanyUsersListSearch extends CompanyUsersList
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['autoId', 'userId', 'noOfCansPerVisit'], 'integer'],
            [['name', 'phoneNo', 'alternatePhoneNo', 'mailId', 'blockNo', 'floorNo', 'departmentName', 'designationName', 'detailedAddress', 'deliveryFrequency', 'status', 'createdAt', 'updatedAt','companyName'], 'safe'],
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
        $query = CompanyUsersList::find()->joinWith('company');

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
            'userId' => $this->userId,
            'noOfCansPerVisit' => $this->noOfCansPerVisit,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'phoneNo', $this->phoneNo])
            ->andFilterWhere(['like', 'alternatePhoneNo', $this->alternatePhoneNo])
            ->andFilterWhere(['like', 'mailId', $this->mailId])
            ->andFilterWhere(['like', 'blockNo', $this->blockNo])
            ->andFilterWhere(['like', 'floorNo', $this->floorNo])
            ->andFilterWhere(['like', 'departmentName', $this->departmentName])
            ->andFilterWhere(['like', 'designationName', $this->designationName])
            ->andFilterWhere(['like', 'detailedAddress', $this->detailedAddress])
            ->andFilterWhere(['like', 'deliveryFrequency', $this->deliveryFrequency])
            ->andFilterWhere(['like', 'user_management.name', $this->companyName])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
