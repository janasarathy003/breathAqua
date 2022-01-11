<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\UserManagement;

/**
 * UserManagementSearch represents the model behind the search form of `backend\models\UserManagement`.
 */
class UserManagementSearch extends UserManagement
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userId', 'noOfCansPerVisit', 'noOfCansDeposite'], 'integer'],
            [['userType', 'name', 'phoneNo', 'alternatePhoneNo', 'mailId', 'referalCode', 'googleLocation', 'address', 'blockNo', 'floorNo', 'detailedAddress', 'deliveryFrequency', 'status', 'createdAt', 'updatedAt'], 'safe'],
            [['userPrice'], 'number'],
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
        $query = UserManagement::find();

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
            'userId' => $this->userId,
            'noOfCansPerVisit' => $this->noOfCansPerVisit,
            'noOfCansDeposite' => $this->noOfCansDeposite,
            'userPrice' => $this->userPrice,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ]);

        $query->andFilterWhere(['like', 'userType', $this->userType])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'phoneNo', $this->phoneNo])
            ->andFilterWhere(['like', 'alternatePhoneNo', $this->alternatePhoneNo])
            ->andFilterWhere(['like', 'mailId', $this->mailId])
            ->andFilterWhere(['like', 'referalCode', $this->referalCode])
            ->andFilterWhere(['like', 'googleLocation', $this->googleLocation])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'blockNo', $this->blockNo])
            ->andFilterWhere(['like', 'floorNo', $this->floorNo])
            ->andFilterWhere(['like', 'detailedAddress', $this->detailedAddress])
            ->andFilterWhere(['like', 'deliveryFrequency', $this->deliveryFrequency])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
