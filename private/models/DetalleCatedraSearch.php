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
            [['id', 'docente', 'catedra', 'condicion', 'revista', 'hora'], 'integer'],
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
            'docente' => $this->docente,
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
        $query = Detallecatedra::find()
            ->where(['catedra' => $id,
                    'activo' => $activo, 
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

     public function providerxdocente($id, $activo)
    {
        $query = Detallecatedra::find()
            ->where(['docente' => $id,
                'activo' => $activo //suplente
            ])
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
                        'docente' => $id,
                        'activo' => Globales::DETCAT_ACTIVO,
                ])
                ->andWhere(['<>', 'revista', Globales::LIC_SINGOCE])->one();//no licencia sin goce
       

        return $query;
        
    }

    public function cantidadHorasConLicenciaSinGoceXDocente($id){

        $query = Detallecatedra::find()
                ->select('sum(hora) as id')
                ->where([
                        'docente' => $id,
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
                where a2.id = a.id and dc2.revista = '.Globales::LIC_VIGENTE.'  and dc2.activo = '.Globales::DETCAT_ACTIVO.'
            ) as cantidad_vigente,(
                SELECT sum(dc3.hora)
                from detallecatedra dc3
                inner join catedra c3 on dc3.catedra = c3.id
                inner join actividad a3 on c3.actividad = a3.id
                where a3.id = a.id and dc3.revista <> '.Globales::LIC_SINGOCE.' and dc3.activo = '.Globales::DETCAT_ACTIVO.'
            ) as horas_cobradas
            from catedra c
            inner join actividad a on c.actividad = a.id';
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
            inner join docente d on dc.docente = d.id
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
        
            $query = Docente::find()
                ->distinct()
                ->joinWith(['detallecatedras', 'detallecatedras.catedra0', 'detallecatedras.catedra0.division0'])
                ->where(['detallecatedra.activo' => 1])
                ->andWhere(['division.propuesta' => $prop])
                
                ->orderBy('docente.apellido, docente.nombre');
                    

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
            $query->from('docente')
            ->distinct()
            ->select('docente.id')
            ->leftJoin('detallecatedra', 'docente.id = detallecatedra.docente')
            ->leftJoin('catedra', 'catedra.id = detallecatedra.catedra')
            ->leftJoin('division', 'division.id = catedra.division')
            ->where(['detallecatedra.activo' => 1])
            ->andWhere(['division.propuesta' => $prop]);
            
            return $query->count('id');

            

    }

    
        
    


}
