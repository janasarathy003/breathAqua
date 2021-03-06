<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\RoleMaster;

/**
 * RoleMasterSearch represents the model behind the search form of `backend\models\RoleMaster`.
 */
class RoleMasterSearch extends RoleMaster
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role_id', 'active_status', 'user_id'], 'integer'],
            [['role_name', 'description', 'created_at', 'updated_at', 'ip_address', 'system_name'], 'safe'],
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
        $query = RoleMaster::find();
        

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
            'role_id' => $this->role_id,
            'active_status' => $this->active_status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'role_name', $this->role_name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'ip_address', $this->ip_address])
            ->andFilterWhere(['like', 'system_name', $this->system_name]);

        return $dataProvider;
    }
}
