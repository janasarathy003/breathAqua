<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\UserLogin;

/**
 * UserLoginSearch represents the model behind the search form of `backend\models\UserLogin`.
 */
class UserLoginSearch extends UserLogin
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'contactNumber', 'roleId', 'login_id', 'franchise_id', 'role_type', 'dept_id', 'user_id'], 'integer'],
            [['master_type', 'name', 'emailId', 'address', 'profileImage', 'role', 'username', 'staff_name', 'auth_key', 'password', 'is_active', 'created_at', 'updated_at', 'ip_address', 'system_name', 'user_role'], 'safe'],
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
        $query = UserLogin::find();

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
            'contactNumber' => $this->contactNumber,
            'roleId' => $this->roleId,
            'login_id' => $this->login_id,
            'franchise_id' => $this->franchise_id,
            'role_type' => $this->role_type,
            'dept_id' => $this->dept_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'master_type', $this->master_type])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'emailId', $this->emailId])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'profileImage', $this->profileImage])
            ->andFilterWhere(['like', 'role', $this->role])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'staff_name', $this->staff_name])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'is_active', $this->is_active])
            ->andFilterWhere(['like', 'ip_address', $this->ip_address])
            ->andFilterWhere(['like', 'system_name', $this->system_name])
            ->andFilterWhere(['like', 'user_role', $this->user_role]);

        return $dataProvider;
    }
}
