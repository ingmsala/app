<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Rolexuser;

/**
 * RolexuserSearch represents the model behind the search form of `app\models\Rolexuser`.
 */
class RolexuserSearch extends Rolexuser
{
    public $nameusername;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user', 'role'], 'integer'],
            [['subrole', 'nameusername'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Rolexuser::find()->innerJoinWith('user0', true);;

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $dataProvider->sort->attributes['user0'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['user0.username' => SORT_ASC],
            'desc' => ['user0.username' => SORT_DESC],
            ];

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            //'user' => $this->user,
            'role' => $this->role,
        ]);

        $query->andFilterWhere(['like', 'subrole', $this->subrole]);
        $query->andFilterWhere(['like', 'user.username', $this->nameusername]);

        return $dataProvider;
    }

    public function xusuario($id)
    {
        $query = Rolexuser::find()->where(['user' => $id]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($id);

        

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            //'user' => $this->user,
            //'role' => $this->role,
        ]);

        $query->andFilterWhere(['like', 'subrole', $this->subrole]);
        $query->andFilterWhere(['like', 'user0.username', $this->user]);
        //$query->andFilterWhere(['like', 'subrole', $this->subrole]);

        return $dataProvider;
    }
}
