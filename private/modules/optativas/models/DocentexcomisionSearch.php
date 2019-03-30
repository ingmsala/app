<?php

namespace app\modules\optativas\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\optativas\models\Docentexcomision;

/**
 * DocentexcomisionSearch represents the model behind the search form of `app\modules\optativas\models\Docentexcomision`.
 */
class DocentexcomisionSearch extends Docentexcomision
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'docente', 'comision', 'role'], 'integer'],
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
        $query = Docentexcomision::find();

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
            'docente' => $this->docente,
            'comision' => $this->comision,
        ]);

        return $dataProvider;
    }

    public function providerdocentes($id)
    {
        $query = Docentexcomision::find()
            ->joinWith(['docente0'])
            ->where(['comision' => $id])
            ->andWhere(['role' => 8])
            ->orderBy('docente.apellido', 'docente.nombre');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        return $dataProvider;

    }

    public function providerpreceptores($id)
    {
        $query = Docentexcomision::find()
            ->joinWith(['docente0'])
            ->where(['comision' => $id])
            ->andWhere(['role' => 9])
            ->orderBy('docente.apellido', 'docente.nombre');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        return $dataProvider;

    }

    public function providerxdocente($id)
    {
        $query = Docentexcomision::find()
            ->joinWith(['docente0', 'comision0', 'comision0.optativa0', 'comision0.optativa0.actividad0'])
            ->where(['docente.legajo' => $id,
            ])
            ->orderBy('actividad.nombre', 'optativa.nombre');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        return $dataProvider;

    }

    public function comisionesxdocente($id)
    {
       return Docentexcomision::find()
            ->joinWith(['docente0', 'comision0', 'comision0.optativa0', 'comision0.optativa0.actividad0'])
            ->where(['docente.legajo' => $id,
            ])
            ->orderBy('actividad.nombre', 'optativa.nombre')
            ->all();

    }
}
