<?php

namespace app\modules\curriculares\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\curriculares\models\Docentexcomision;
use app\config\Globales;

/**
 * DocentexcomisionSearch represents the model behind the search form of `app\modules\espaciocurriculars\models\Docentexcomision`.
 */
class DocentexcomisionSearch extends Docentexcomision
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'agente', 'comision', 'role'], 'integer'],
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
            'agente' => $this->agente,
            'comision' => $this->comision,
        ]);

        return $dataProvider;
    }

    public function providerdocentes($id)
    {
        $query = Docentexcomision::find()
            ->joinWith(['agente0'])
            ->where(['comision' => $id])
            ->andWhere(['role' => 8])
            ->orderBy('agente.apellido', 'agente.nombre');

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
            ->joinWith(['agente0'])
            ->where(['comision' => $id])
            ->andWhere(['role' => 9])
            ->orderBy('agente.apellido', 'agente.nombre');

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

    public function providerxdocente($id, $tipoespacio)
    {
        $query = Docentexcomision::find()
            ->joinWith(['agente0', 'comision0', 'comision0.espaciocurricular0', 'comision0.espaciocurricular0.actividad0'])
            ->where(['agente.legajo' => $id,
            ])
            ->andWhere(['espaciocurricular.tipoespacio' => $tipoespacio])
            ->orderBy('actividad.nombre', 'espaciocurricular.nombre');

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

    public function comisionesxdocente($id, $tipoespacio)
    {
        if(in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_SACADEMICA, Globales::US_COORDINACION, Globales::US_SREI, Globales::US_CONSULTA, Globales::US_SECRETARIA, Globales::US_PSC])){
            return Docentexcomision::find()
            ->joinWith(['agente0', 'comision0', 'comision0.espaciocurricular0', 'comision0.espaciocurricular0.actividad0'])
            ->where(['espaciocurricular.tipoespacio' => $tipoespacio])
            ->orderBy('actividad.nombre', 'espaciocurricular.nombre')
            ->all();
        }
       return Docentexcomision::find()
            ->joinWith(['agente0', 'comision0', 'comision0.espaciocurricular0', 'comision0.espaciocurricular0.actividad0'])
            ->where(['agente.legajo' => $id,
            ])
            ->andWhere(['espaciocurricular.tipoespacio' => $tipoespacio])
            ->orderBy('actividad.nombre', 'espaciocurricular.nombre')
            ->all();

    }
}
