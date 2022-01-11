<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Role;

/**
 * RoleSearch represents the model behind the search form of `backend\models\Role`.
 */
class RoleSearch extends Role
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','user_id'], 'integer'],
            [['role_description','role_name','franchise_type', 'active_status','user_type', 'created_at', 'updated_at', 'ip_address', 'system_name', 'user_role'], 'safe'],
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

        $session = Yii::$app->session;
        
        if($session['master_type'] == 'B' || $session['master_type']=='')
        {
            $query = Role::find()->where(['IN','active_status',[0,1]])->andWhere(['role_type'=>'D'])->orderBy(['id'=>SORT_DESC]);
        }
        else if($session['master_type'] == 'F')
        {
            $query = Role::find()->where(['IN','active_status',[0,1]])->andWhere(['role_type'=>'F'])->andWhere(['ref_id'=>$session['branch_id']])->orderBy(['id'=>SORT_DESC]);
        }

        

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
            'role_name' => $this->role_name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'role_description', $this->role_description])
            ->andFilterWhere(['like', 'active_status', $this->active_status])
            ->andFilterWhere(['like', 'user_type', $this->user_type])
           
            ->andFilterWhere(['like', 'ip_address', $this->ip_address])
            ->andFilterWhere(['like', 'system_name', $this->system_name])
            ->andFilterWhere(['like', 'user_role', $this->user_role]);

        return $dataProvider;
    }


    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function managesearch($params)
    {
        $query = Role::find()->where(['IN','active_status',[0,1]])->orderBy(['id'=>SORT_DESC]);
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
            'role_name' => $this->role_name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'role_description', $this->role_description])
            ->andFilterWhere(['like', 'active_status', $this->active_status])
            ->andFilterWhere(['like', 'user_type', $this->user_type])
            ->andFilterWhere(['like', 'ip_address', $this->ip_address])
            ->andFilterWhere(['like', 'system_name', $this->system_name])
            ->andFilterWhere(['like', 'user_role', $this->user_role]);
        return $dataProvider;
       }
    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchfranchise($params)
    {
        $session = Yii::$app->session;
        // $query = Role::find();
        // $query->joinWith(['ref']); 
        if($session['master_type'] == 'F')
        {
            $query = Role::find()->where(['IN','role.active_status',[0,1]])->andWhere(['role_type'=>'F'])->andWhere(['ref_id'=>$session['branch_id']])->orderBy(['id'=>SORT_DESC]);
            $query->joinWith(['ref']);    
        }
        else
        {
            $query = Role::find()
            ->where(['IN','role.active_status',[0,1]])
            ->andWhere(['role_type'=>'F']);  
            $query->joinWith(['ref']);     
        }
        

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
            'role_name' => $this->role_name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'role_description', $this->role_description])
            ->andFilterWhere(['like', 'role.active_status', $this->active_status])
            ->andFilterWhere(['like', 'role.user_type', $this->user_type])
            ->andFilterWhere(['like', 'ip_address', $this->ip_address])
            ->andFilterWhere(['like', 'system_name', $this->system_name])
           ->andFilterWhere(['like', 'franchise_master.company_name', $this->franchise_type])
            ->andFilterWhere(['like', 'user_role', $this->user_role]);

        return $dataProvider;
    }
}
