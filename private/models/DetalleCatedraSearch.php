<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Detallecatedra;
use yii\data\SqlDataProvider;
use yii\db\Query;
use app\config\Globales;

/**
 * DetalleCatedraSearch represents the model behind the search form of `app\models\DetalleCatedra`.
 */
class DetallecatedraSearch extends Detallecatedra
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'agente', 'catedra', 'condicion', 'revista', 'hora', 'aniolectivo'], 'integer'],
            [['fechaInicio', 'fechaFin', 'resolucion'], 'safe'],
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
        $query = Detallecatedra::find();

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
            'catedra' => $this->catedra,
            'condicion' => $this->condicion,
            'revista' => $this->revista,
            'resolucion' => $this->resolucion,
            'fechaInicio' => $this->fechaInicio,
            'fechaFin' => $this->fechaFin,
        ]);

        
        return $dataProvider;
    }

    public function providerxcatedra($id, $activo)
    {
        if(Yii::$app->user->identity->role == Globales::US_SUPER){
            $query = Detallecatedra::find()
            ->where(['catedra' => $id,
                    'activo' => $activo, 
            ])
            ->orderBy('condicion ASC', 'id ASC');
        }else{
            $query = Detallecatedra::find()
            ->where(['catedra' => $id,
                    'activo' => $activo, 
            ])
            ->andWhere(['<>', 'condicion', 6])
            ->orderBy('condicion ASC', 'id ASC');
        }
        

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

     public function providerxdocente($id, $activo)
    {
        $query = Detallecatedra::find()
            ->where(['agente' => $id,
                'activo' => $activo //suplente
            ])
            ->andWhere(['<>', 'condicion', 6])
            ->orderBy('revista ASC', 'id ASC');

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

        $query = Detallecatedra::find()
                ->select('sum(hora) as id')
                ->where([
                        'agente' => $id,
                        'activo' => Globales::DETCAT_ACTIVO,
                ])
                ->andWhere(['<>', 'condicion', 6])
                ->andWhere(['<>', 'revista', Globales::LIC_SINGOCE])->one();//no licencia sin goce
       

        return $query;
        
    }

    public function cantidadHorasConLicenciaSinGoceXDocente($id){

        $query = Detallecatedra::find()
                ->select('sum(hora) as id')
                ->where([
                        'agente' => $id,
                        'activo' => Globales::DETCAT_ACTIVO,
                ])
                ->andWhere(['revista' => Globales::LIC_SINGOCE])->one();// lic s/goce
        

        return $query;
        
    }

    public function horasXMateriaXCatedra($params)
        {
        
            $sql='
            select a.id as id, a.nombre as actividad, count(c.actividad) as cantidad_catedras, count(c.actividad)*a.cantHoras as horas_semanales, (
                SELECT sum(dc2.hora)
                from detallecatedra dc2
                inner join catedra c2 on dc2.catedra = c2.id
                inner join actividad a2 on c2.actividad = a2.id
                inner join division di2 on c2.division = di2.id
                where a2.id = a.id and di2.turno is not null and dc2.revista = '.Globales::LIC_VIGENTE.'  and dc2.activo = '.Globales::DETCAT_ACTIVO.'
            ) as cantidad_vigente,(
                SELECT sum(dc3.hora)
                from detallecatedra dc3
                inner join catedra c3 on dc3.catedra = c3.id
                inner join actividad a3 on c3.actividad = a3.id
                inner join division di3 on c3.division = di3.id
                where a3.id = a.id and di3.turno is not null and dc3.revista <> '.Globales::LIC_SINGOCE.' and dc3.activo = '.Globales::DETCAT_ACTIVO.'
            ) as horas_cobradas
            from catedra c
            inner join actividad a on c.actividad = a.id
            inner join division di on c.division = di.id
            where di.turno is not null';
            if (isset($params['Actividad']['id']) && $params['Actividad']['id'] != ''){
                $sql .= ' where a.id = '.$params['Actividad']["id"];
            }
            $sql .= ' group by a.nombre

            order by c.id

        '; //1 es vigente y 2 es diferente a lic s/goce


        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
            'pagination' => false,
            
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }



        
        // grid filtering conditions
        

        return $dataProvider;

    }


    public function providerDocentesxActividad($actividad){
        
        $sql='
            select c.id as id, di.nombre as division, d.apellido as apellido, d.nombre as nombre, sum(dc.hora) as horas
            from catedra c
            inner join actividad a on c.actividad = a.id
            inner join detallecatedra dc on dc.catedra = c.id
            inner join division di on c.division = di.id
            inner join agente d on dc.agente = d.id
            where a.id = '.$actividad.' 
            and dc.revista = '.Globales::LIC_VIGENTE.'
            and dc.activo = '.Globales::DETCAT_ACTIVO.'
            group by di.nombre, d.apellido, d.nombre
            order by di.id'; //1 es vigente y 2 es diferente a lic s/goce


        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
            'pagination' => false,
            
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }



        
        // grid filtering conditions
        

        return $dataProvider;

    }

    public function getPadronDocente($prop){
        
            $query = Agente::find()
                ->distinct()
                ->joinWith(['detallecatedras', 'detallecatedras.catedra0', 'detallecatedras.catedra0.division0'])
                ->where(['detallecatedra.activo' => 1])
                ->andWhere(['division.propuesta' => $prop])
                
                ->orderBy('agente.apellido, agente.nombre');
                    

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        return $dataProvider;
    }

    public function getCantidadDocentes($prop){
            $query = new Query();
            $query->from('agente')
            ->distinct()
            ->select('agente.id')
            ->leftJoin('detallecatedra', 'agente.id = detallecatedra.agente')
            ->leftJoin('catedra', 'catedra.id = detallecatedra.catedra')
            ->leftJoin('division', 'division.id = catedra.division')
            ->where(['detallecatedra.activo' => 1])
            ->andWhere(['division.propuesta' => $prop]);
            
            return $query->count('id');

            

    }

    public function horario_doce_divi($division, $al)
    {
        
        $query = Detallecatedra::find()
            ->joinWith(['catedra0', 'catedra0.actividad0'])
            ->where(['catedra.division' => $division])
            ->andWhere(['<>', 'actividad.id', 31])
            ->andWhere(['<>', 'actividad.id', 33])
            ->andWhere(['<>', 'actividad.id', 195])
            ->andWhere(['revista' => 6])
            ->andWhere(['aniolectivo' => $al])
            ->orderBy('actividad.nombre');
        
        

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

       // $this->load($dia, $curso);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        

        return $dataProvider;
    }

    public function horario_doce_divi_cant($division, $al)
    {
        
        $query = Detallecatedra::find()
            ->joinWith(['catedra0', 'catedra0.actividad0'])
            ->where(['catedra.division' => $division])
            ->andWhere(['<>', 'actividad.id', 31])
            ->andWhere(['<>', 'actividad.id', 33])
            ->andWhere(['<>', 'actividad.id', 195])
            ->andWhere(['revista' => 6])
            ->andWhere(['aniolectivo' => $al])
            ->orderBy('actividad.nombre');
        
        

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

       // $this->load($dia, $curso);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        

        return $dataProvider;
    }

    
        
    


}
