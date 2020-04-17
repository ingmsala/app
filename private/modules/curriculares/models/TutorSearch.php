<?php

namespace app\modules\curriculares\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\curriculares\models\Tutor;

/**
 * TutorSearch represents the model behind the search form of `app\modules\optativas\models\Tutor`.
 */
class TutorSearch extends Tutor
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'alumno'], 'integer'],
            [['apellido', 'nombre', 'mail', 'telefono', 'parentezco'], 'safe'],
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
        $query = Tutor::find();

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
            'alumno' => $this->alumno,
        ]);

        $query->andFilterWhere(['like', 'apellido', $this->apellido])
            ->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'mail', $this->mail])
            ->andFilterWhere(['like', 'telefono', $this->telefono])
            ->andFilterWhere(['like', 'parentezco', $this->parentezco]);

        return $dataProvider;
    }

    public function tutoresxalumno($id)
    {
        $query = Tutor::find()->where(['alumno' => $id]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        $this->load($id);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        

        return $dataProvider;
    }
}
