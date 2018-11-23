<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Nombramiento;

/**
 * NombramientoSearch represents the model behind the search form of `app\models\Nombramiento`.
 */
class NombramientoSearch extends Nombramiento
{
    
    public $revista;
    public $docente;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'cargo','horas', ], 'integer'],
            [['nombre', 'revista', 'docente', 'division', 'suplente'], 'safe'],
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
        $query = Nombramiento::find()->joinWith(['docente0', 'revista0', 'division0', 'suplente0 n']);

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

    
        $dataProvider->sort->attributes['revista0'] = [
        'asc' => ['revista.nombre' => SORT_ASC],
        'desc' => ['revista.nombre' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['docente0'] = [
        'asc' => ['docente.apellido' => SORT_ASC],
        'desc' => ['docente.apellido' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['division0'] = [
        'asc' => ['division.nombre' => SORT_ASC],
        'desc' => ['division.nombre' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['suplente0'] = [
        'asc' => ['suplente.apellido' => SORT_ASC],
        'desc' => ['suplente.apellido' => SORT_DESC],
        ];

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'cargo' => $this->cargo,
            'horas' => $this->horas,
            
        ]);

        $query->andFilterWhere(['like', 'revista.nombre', $this->revista])
        ->andFilterWhere(['like', 'docente.apellido', $this->docente])
        ->andFilterWhere(['like', 'division.nombre', $this->division])
        ->andFilterWhere(['like', 'n.docente0.apellido', $this->suplente]);
        


        return $dataProvider;
    }

    public function providerxsuplente($id)
    {
        $query = Nombramiento::find()
            ->where(['id' => $id,
                //'condicion' => 5 //suplente
            ])
            ->orderBy('condicion ASC', 'id ASC');

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

    public function cantidadHorasACobrarXDocente($id){

        $query = Nombramiento::find()
                ->select('sum(horas) as horas')
                ->where(['docente' => $id])
                ->andWhere(['<>', 'revista', 2])->one();//no licencia sin goce


        return $query;
        
    }

    public function cantidadHorasConLicenciaSinGoceXDocente($id){

        $query = Nombramiento::find()
                ->select('sum(horas) as horas')
                ->where(['docente' => $id])
                ->andWhere(['revista' => 2])->one();// lic s/goce


        return $query;
        
    }


    public function searchByDocente($id)
    {
        $query = Nombramiento::find()
                ->where(['docente' => $id]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

    
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'cargo' => $this->cargo,
            'horas' => $this->horas,
            'division' => $this->division,
            'suplente' => $this->suplente,
        ]);

        $query->andFilterWhere(['like', 'revista.nombre', $this->revista])
        ->andFilterWhere(['like', 'docente.apellido', $this->docente]);
        


        return $dataProvider;
    }

    public function getPreceptores()
    {
        $query = Nombramiento::find()
                ->where(['cargo' => 227]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

    
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'cargo' => $this->cargo,
            'horas' => $this->horas,
            'division' => $this->division,
            'suplente' => $this->suplente,
        ]);

        $query->andFilterWhere(['like', 'revista.nombre', $this->revista])
        ->andFilterWhere(['like', 'docente.apellido', $this->docente]);
        


        return $dataProvider;
    }
}