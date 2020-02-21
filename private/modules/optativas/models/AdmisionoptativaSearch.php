<?php

namespace app\modules\optativas\models;

use Yii;
use app\modules\optativas\models\Admisionoptativa;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;

/**
 * AdmisionoptativaSearch represents the model behind the search form of `app\modules\optativas\models\Admisionoptativa`.
 */
class AdmisionoptativaSearch extends Admisionoptativa
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'alumno', 'curso', 'aniolectivo'], 'integer'],
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
        $query = Admisionoptativa::find();

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
            'curso' => $this->curso,
            'aniolectivo' => $this->aniolectivo,
        ]);

        return $dataProvider;
    }

    public function porAlumno($id)
    {
        $sql = "SELECT alumno, curso, count(id) as cantidad FROM admisionoptativa  WHERE alumno = ".$id." and aniolectivo = 2  group by alumno, curso";

        // add conditions that should always apply here

        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
            'pagination' => false,
        ]);

        $this->load($id);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        
        return $dataProvider;
    }
}
