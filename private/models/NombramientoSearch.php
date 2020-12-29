<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Nombramiento;
use yii\db\Query;
use app\config\Globales;

/**
 * NombramientoSearch represents the model behind the search form of `app\models\Nombramiento`.
 */
class NombramientoSearch extends Nombramiento
{
    
    public $revista;
    public $agente;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'cargo','horas', 'activo'], 'integer'],
            [['nombre', 'revista', 'agente', 'division', 'suplente', 'extension', 'resolucion', 'fechaInicio', 'fechaFin', 'resolucionext', 'fechaInicioext', 'fechaFinext'], 'safe'],
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
        $query = Nombramiento::find()->joinWith(['agente0', 'revista0', 'division0', 'condicion0', 'suplente0 n', 'extension0'])
                        //->where(['!=','condicion.nombre', 'SUPL'] )
                        ->where(true)
                        ->andWhere(

                            (isset($params['Nombramiento']['cargo']) && $params['Nombramiento']['cargo'] != '') ? ['nombramiento.cargo' => $params['Nombramiento']['cargo']] : true)
                        ->andWhere(

                            (isset($params['Nombramiento']['agente']) && $params['Nombramiento']['agente'] != '') ? 
                            [   
                                'or', 
                                ['nombramiento.agente' => $params['Nombramiento']['agente']],
                                ['n.agente' => $params['Nombramiento']['agente']]
                            ] : true)
                        ->andWhere(

                            (isset($params['Nombramiento']['revista']) && $params['Nombramiento']['revista'] != '') ? ['nombramiento.revista' => $params['Nombramiento']['revista']] : true)
                        ->andWhere(

                            (isset($params['Nombramiento']['condicion']) && $params['Nombramiento']['condicion'] != '') ? ['nombramiento.condicion' => $params['Nombramiento']['condicion']] : ['!=','condicion.nombre', 'SUPL'])
                        ->andWhere(

                            (isset($params['Nombramiento']['resolucion']) && $params['Nombramiento']['resolucion'] != '') ? ['nombramiento.resolucion' => $params['Nombramiento']['resolucion']] : true)
                        ->andWhere(

                            (isset($params['Nombramiento']['resolucionext']) && $params['Nombramiento']['resolucionext'] != '') ? ['nombramiento.resolucionext' => $params['Nombramiento']['resolucionext']] : true)
                        ->orderBy('nombramiento.cargo, agente.apellido, agente.nombre');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
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

        $dataProvider->sort->attributes['agente0'] = [
        'asc' => ['agente.apellido' => SORT_ASC],
        'desc' => ['agente.apellido' => SORT_DESC],
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
            'nombramiento.cargo' => $this->cargo,
            'nombramiento.horas' => $this->horas,
            
        ]);

        $query->andFilterWhere(['like', 'revista.nombre', $this->revista])
        ->andFilterWhere(['like', 'agente.apellido', $this->agente])
        ->andFilterWhere(['like', 'division.nombre', $this->division])
        ->andFilterWhere(['like', 'agente.apellido', $this->suplente]);
        


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
                ->where(['agente' => $id])
                ->andWhere(['<>', 'revista', Globales::LIC_SINGOCE])->one();//no licencia sin goce


        return $query;
        
    }

    public function cantidadHorasConLicenciaSinGoceXDocente($id){

        $query = Nombramiento::find()
                ->select('sum(horas) as horas')
                ->where(['agente' => $id])
                ->andWhere(['revista' => Globales::LIC_SINGOCE])->one();// lic s/goce


        return $query;
        
    }


    public function searchByDocente($id)
    {
        $query = Nombramiento::find()
                ->where(['agente' => $id]);

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
        ->andFilterWhere(['like', 'agente.apellido', $this->agente]);
        


        return $dataProvider;
    }

    public function getPreceptores($todos = 1)
    {
        if($todos == 1){
            $query = Nombramiento::find()
                ->where(['cargo' => Globales::CARGO_PREC])
                ->orderBy('revista, division');

        }else{
            $query = Nombramiento::find()
                ->joinWith(['division0'])
                ->where(['cargo' => Globales::CARGO_PREC])
                ->andWhere(['revista' => 1])
                ->orderBy('division.nombre');
        }
        
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
        ->andFilterWhere(['like', 'agente.apellido', $this->agente]);
        


        return $dataProvider;
    }

    public function getPadronPreceptores($prop)
    {
        if($prop ==1){
            $query = Agente::find()
                ->distinct()
                ->joinWith(['nombramientos', 'nombramientos.division0'])
                ->where(['nombramiento.cargo' => Globales::CARGO_PREC])
                ->andWhere(['or', 
                    ['division.propuesta' => $prop],
                    ['nombramiento.division' => null]
                ])
                
                ->orderBy('agente.apellido, agente.nombre');
            }else{
                 $query = Agente::find()
                ->distinct()
                ->joinWith(['nombramientos', 'nombramientos.division0'])
                ->where(['nombramiento.cargo' => Globales::CARGO_PREC])
                ->andWhere(['or', 
                    ['division.propuesta' => $prop],
                    
                ])
                
                ->orderBy('agente.apellido, agente.nombre');
            }
        

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

    public function getPadronJefes($prop)
    {
        if($prop ==1){
            $query = Agente::find()
                ->distinct()
                ->joinWith(['nombramientos', 'nombramientos.division0'])
                ->where(['nombramiento.cargo' => Globales::CARGO_JEFE])
                ->andWhere(['or', 
                    ['division.propuesta' => $prop],
                    ['nombramiento.division' => null]
                ])
                
                ->orderBy('agente.apellido, agente.nombre');
            }else{
                 $query = Agente::find()
                ->distinct()
                ->joinWith(['nombramientos', 'nombramientos.division0'])
                ->where(['nombramiento.cargo' => Globales::CARGO_JEFE])
                ->andWhere(['or', 
                    ['division.propuesta' => $prop],
                    
                ])
                
                ->orderBy('agente.apellido, agente.nombre');
            }
        

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

    public function getPadronOtrosDocente($prop, $param){
        
            
            try{
                 $largo = count($param);
             }catch(\Exception $exception){
                $largo = 0;
            }

            if($largo < 1){

                $query = Agente::find()
                ->distinct()
                ->joinWith(['nombramientos', 'nombramientos.division0'])
                ->where(['nombramiento.cargo' => Globales::CARGO_JEFE])
                ->andWhere(['or', 
                    ['division.propuesta' => $prop],
                    ['nombramiento.division' => null]
                ])
                
                ->orderBy('agente.apellido, agente.nombre');
            }else{

                
                if($prop ==1){
                    $query = Agente::find()
                                    ->distinct()
                                    ->joinWith(['nombramientos', 'nombramientos.division0'])
                                    ->where(true)
                                    ->andWhere(['in', 
                                        'cargo', $param
                                    ])
                                    ->andWhere(['or', 
                                        ['division.propuesta' => $prop],
                                        ['nombramiento.division' => null]
                                    ])
                                    ->orderBy('agente.apellido, agente.nombre');
                }else{
                    $query = Agente::find()
                                    ->distinct()
                                    ->joinWith(['nombramientos', 'nombramientos.division0'])
                                    ->where(true)
                                    ->andWhere(['in', 
                                        'cargo', $param
                                    ])
                                    ->andWhere(['division.propuesta' => $prop])
                                    ->orderBy('agente.apellido, agente.nombre');
                }
                


            }
            
                    

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

    public function getCantidadPreceptores($prop){
        $query = new Query();
        if($prop ==1){
            $query->from('agente')
                        ->distinct()
                    ->select('agente.id')
                        //->join(['nombramientos', 'nombramientos.division0'])
                    ->leftJoin('nombramiento', 'agente.id = nombramiento.agente')
                    ->leftJoin('division', 'division.id = nombramiento.division')
                    ->where(['nombramiento.cargo' => Globales::CARGO_PREC])
                    ->andWhere(['or', 
                        ['division.propuesta' => $prop],
                        ['nombramiento.division' => null]
                    ]);
            return $query->count('id');

        }else{
            $query->from('agente')
                        ->distinct()
                    ->select('agente.id')
                        //->join(['nombramientos', 'nombramientos.division0'])
                    ->leftJoin('nombramiento', 'agente.id = nombramiento.agente')
                    ->leftJoin('division', 'division.id = nombramiento.division')
                    ->where(['nombramiento.cargo' => Globales::CARGO_PREC])
                    ->andWhere(['or', 
                        ['division.propuesta' => $prop],
                        
                    ]);
            return $query->count('id');
        }
        
    }

    public function getCantidadJefes($prop){
        $query = new Query();
        if($prop ==1){
            $query->from('agente')
                        ->distinct()
                    ->select('agente.id')
                        //->join(['nombramientos', 'nombramientos.division0'])
                    ->leftJoin('nombramiento', 'agente.id = nombramiento.agente')
                    ->leftJoin('division', 'division.id = nombramiento.division')
                    ->where(['nombramiento.cargo' => Globales::CARGO_JEFE])
                    ->andWhere(['or', 
                        ['division.propuesta' => $prop],
                        ['nombramiento.division' => null]
                    ]);
            return $query->count('id');

        }else{
            $query->from('agente')
                        ->distinct()
                    ->select('agente.id')
                        //->join(['nombramientos', 'nombramientos.division0'])
                    ->leftJoin('nombramiento', 'agente.id = nombramiento.agente')
                    ->leftJoin('division', 'division.id = nombramiento.division')
                    ->where(['nombramiento.cargo' => Globales::CARGO_JEFE])
                    ->andWhere(['or', 
                        ['division.propuesta' => $prop],
                        
                    ]);
            return $query->count('id');
        }
        
    }

    public function getCantidadOtrosDocentes($prop, $param){
            $query = new Query();
            try{
                 $largo = count($param);
             }catch(\Exception $exception){
                $largo = 0;
            }
                if($prop ==1){
                    $query->from('agente')
                    ->distinct()
                    ->select('agente.id')
                    ->leftJoin('nombramiento', 'agente.id = nombramiento.agente')
                    ->leftJoin('division', 'division.id = nombramiento.division')
                    
                    ->where(['in', 
                    'cargo', $param
                    ])
                    ->andWhere(['or', 
                        ['division.propuesta' => $prop],
                        ['nombramiento.division' => null]
                    ]);
                }else{
                     $query->from('agente')
                    ->distinct()
                    ->select('agente.id')
                    ->leftJoin('nombramiento', 'agente.id = nombramiento.agente')
                    ->leftJoin('division', 'division.id = nombramiento.division')
                    
                    ->where(['in', 
                    'cargo', $param
                    ])
                    ->andWhere(['division.propuesta' => $prop]);
                }
                return $query->count('id');

            

    }

}
