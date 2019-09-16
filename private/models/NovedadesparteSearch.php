<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Novedadesparte;
use app\config\Globales;


/**
 * NovedadesparteSearch represents the model behind the search form of `app\models\Novedadesparte`.
 */
class NovedadesparteSearch extends Novedadesparte
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'tiponovedad', 'parte', 'docente', 'activo'], 'integer'],
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
        $query = Novedadesparte::find()
                    ->joinWith(['tiponovedad0', 'parte0', 'estadoxnovedads'])
                    ->where(['activo' => 1])
                    ->andWhere(['in', 'tiponovedad', $tipodenovedadXusuario])
                    ->orderBy('parte.fecha');

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
            'tiponovedad' => $this->tiponovedad,
            'parte' => $this->parte,
            
        ]);

        $query->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }

    public function novedadesxparte($id)
    {
        $query = Novedadesparte::find()
                    ->joinWith(['tiponovedad0'])
                    ->where(['activo' => 1])
                    ->andWhere(['not in', 'tiponovedad', Globales::TIPO_NOV_X_USS[3]])
                    ->andWhere(['parte' => $id])
                    ->orderBy('tiponovedad.id');

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
            'tiponovedad' => $this->tiponovedad,
            'parte' => $this->parte,
            
        ]);

        $query->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }

    public function novedadesEdiliciasActivas($id)
    {
        $model = Parte::find()->where(['id' => $id])->one();
        $fecha = $model->fecha;
        $nuevafecha = strtotime ( '-10 day' , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( 'Y-m-d' , $nuevafecha );

        $query = Novedadesparte::find()
                    ->joinWith(['tiponovedad0', 'estadoxnovedads', 'parte0'])
                    //->where(['activ' => 1])
                    ->andWhere(['parte.preceptoria' => $model->preceptoria])
                    ->andWhere(['in', 'tiponovedad', Globales::TIPO_NOV_X_USS[3]])
                    ->andWhere(['or', 
                                ['and',
                                        ['activo' => 1],
                                        
                                ],
                                ['and',
                                        ['activo' => 2],
                                        ['=', 'estadoxnovedad.estadonovedad', 3],
                                        ['>', 'estadoxnovedad.fecha', $nuevafecha]
                                ],
                                
                        ])
                    ->orderBy('estadoxnovedad.fecha DESC, parte.fecha DESC');

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
            'tiponovedad' => $this->tiponovedad,
            'parte' => $this->parte,
            
        ]);

        $query->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }

    public function novedadesactivas($tipodenovedadXusuario, $descrip)
    {
        if ($descrip != null)
            $query = Novedadesparte::find()
                    ->joinWith(['tiponovedad0', 'parte0', 'estadoxnovedads'])
                    ->where(['activo' => 1])
                    ->andWhere(['in', 'tiponovedad', $tipodenovedadXusuario])
                     ->andWhere(['like', 'descripcion', $descrip])
                    ->orderBy('parte.fecha');
        else{
            $query = Novedadesparte::find()
                    ->joinWith(['tiponovedad0', 'parte0', 'estadoxnovedads'])
                    ->where(['activo' => 1])
                    ->andWhere(['in', 'tiponovedad', $tipodenovedadXusuario])
                    ->orderBy('parte.fecha');  
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
            'tiponovedad' => $this->tiponovedad,
            'parte' => $this->parte,
            
        ]);

        $query->andFilterWhere(['like', 'descripcion', $descrip]);

        return $dataProvider;
    }

    public function novedadesall($tipodenovedadXusuario, $descrip)
    {
        if ($descrip != null){
            if(Yii::$app->user->identity->role == Globales::US_PRECEPTORIA)
                            $query = Novedadesparte::find()
                                    ->joinWith(['tiponovedad0', 'parte0', 'estadoxnovedads', 'parte0.preceptoria0'])
                                    ->where(['in', 'tiponovedad', $tipodenovedadXusuario])
                                    ->andWhere(['preceptoria.nombre' => Yii::$app->user->identity->username])
                                    ->andWhere(['like', 'novedadesparte.descripcion', $descrip])
                                    ->orderBy('novedadesparte.descripcion, parte.fecha');
                        elseif(Yii::$app->user->identity->role == Globales::US_NOVEDADES)
                            $query = Novedadesparte::find()
                                    ->joinWith(['tiponovedad0', 'parte0', 'estadoxnovedads'])
                                    ->where(['activo' => 2])
                                    ->andWhere(['in', 'tiponovedad', $tipodenovedadXusuario])
                                    ->andWhere(['like', 'novedadesparte.descripcion', $descrip])
                                    ->orderBy('parte.fecha');
                        else
                            $query = Novedadesparte::find()
                                    ->joinWith(['tiponovedad0', 'parte0', 'estadoxnovedads'])
                                    ->where(['activo' => 2])
                                    ->andWhere(['in', 'tiponovedad', $tipodenovedadXusuario])
                                    ->andWhere(['like', 'novedadesparte.descripcion', $descrip])
                                    ->orderBy('parte.fecha');
                }else{
                        if(Yii::$app->user->identity->role == Globales::US_PRECEPTORIA)
                            $query = Novedadesparte::find()
                                    ->joinWith(['tiponovedad0', 'parte0', 'estadoxnovedads', 'parte0.preceptoria0'])
                                    ->where(['in', 'tiponovedad', $tipodenovedadXusuario])
                                    ->andWhere(['preceptoria.nombre' => Yii::$app->user->identity->username])
                                    ->orderBy('novedadesparte.descripcion, parte.fecha');
                        elseif(Yii::$app->user->identity->role == Globales::US_NOVEDADES)
                            $query = Novedadesparte::find()
                                    ->joinWith(['tiponovedad0', 'parte0', 'estadoxnovedads'])
                                    ->where(['activo' => 2])
                                    ->andWhere(['in', 'tiponovedad', $tipodenovedadXusuario])
                                    ->orderBy('parte.fecha');
                        else
                            $query = Novedadesparte::find()
                                    ->joinWith(['tiponovedad0', 'parte0', 'estadoxnovedads'])
                                    ->where(['activo' => 2])
                                    ->andWhere(['in', 'tiponovedad', $tipodenovedadXusuario])
                                    ->orderBy('parte.fecha');
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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'tiponovedad' => $this->tiponovedad,
            'parte' => $this->parte,
            
        ]);

        $query->andFilterWhere(['like', 'descripcion', $this->descripcion]);
        $query->andFilterWhere(['like', 'activo', $this->activo]);


        return $dataProvider;
    }

     public function novedadesactivascant()
    {
        $query = Novedadesparte::find()
                    ->joinWith(['estadoxnovedads'])
                    ->where(['activo' => 1])
                    ->andWhere(['<>', 'tiponovedad', 1])
                    ->andWhere(['<>', 'tiponovedad', 5])
                    ->count();
        return $query;
    }


    public function novedadesSinNotificar($cant)
    {
        
        $forzarpreceptoria = [
            9 => 1,
            10 => 2,
            11 => 3,
            6 => 4,
            7 => 5,
            8 => 6,
            44 => 8,
            39 => 7,
            
        ];
        $query = Novedadesparte::find()
                    ->joinWith(['tiponovedad0', 'estadoxnovedads', 'parte0'])
                    ->where(['<>', 'estadonovedad', 1])
                    ->andWhere(['parte.preceptoria' => $forzarpreceptoria[Yii::$app->user->identity->id]])
                    ->andWhere(['in', 'tiponovedad', Globales::TIPO_NOV_X_USS[3]])
                    ->orderBy('estadoxnovedad.id DESC')
                    ->limit($cant);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        //$this->load($id);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'tiponovedad' => $this->tiponovedad,
            'parte' => $this->parte,
            
        ]);

        $query->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }
}
