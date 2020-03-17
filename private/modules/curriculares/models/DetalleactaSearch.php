<?php

namespace app\modules\curriculares\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\curriculares\models\Detalleacta;

/**
 * DetalleactaSearch represents the model behind the search form of `app\modules\optativas\models\Detalleacta`.
 */
class DetalleactaSearch extends Detalleacta
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'detalleescala', 'acta', 'matricula'], 'integer'],
            [['descripcion'], 'safe'],
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
        $query = Detalleacta::find();

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
            'detalleescala' => $this->detalleescala,
            'acta' => $this->acta,
            'matricula' => $this->matricula,
        ]);

        $query->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }

    public function alumnosXacta($acta)
    {
        $query = Detalleacta::find()->joinWith(['matricula0', 'matricula0.alumno0'])->where(['acta' => $acta])->orderBy('alumno.apellido, alumno.nombre')->indexBy('id');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false
        ]);

        $this->load($acta);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
       

        return $dataProvider;
    }
}
