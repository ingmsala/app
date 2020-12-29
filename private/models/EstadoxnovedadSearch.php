<?php

namespace app\models;

use Yii;
use app\config\Globales;
use app\models\Anioxtrimestral;
use app\models\Estadoxnovedad;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;

/**
 * EstadoxnovedadSearch represents the model behind the search form of `app\models\Estadoxnovedad`.
 */
class EstadoxnovedadSearch extends Estadoxnovedad
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'novedadesparte', 'estadonovedad'], 'integer'],
            [['fecha'], 'safe'],
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
        $query = Estadoxnovedad::find();

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
            'novedadesparte' => $this->novedadesparte,
            'estadonovedad' => $this->estadonovedad,
            'fecha' => $this->fecha,
        ]);

        return $dataProvider;
    }

    public function novedadesall($tipodenovedadXusuario, $param)
    {
        if(isset($param['Estadoxnovedad']['finddescrip']) && $param['Estadoxnovedad']['finddescrip'] != '')
            $descrip = $param['Estadoxnovedad']['finddescrip'];
        else
            $descrip = '';
        if(isset($param['Estadoxnovedad']['estadonovedad']) && $param['Estadoxnovedad']['estadonovedad'] != '')
            $estado = $param['Estadoxnovedad']['estadonovedad'];
        else
            $estado = [10,20,30,40,50];

        if(isset($param['Estadoxnovedad']['aniolectivo']) && $param['Estadoxnovedad']['aniolectivo'] != '')
            $aniolectivo = $param['Estadoxnovedad']['aniolectivo'];
        else
            $aniolectivo = 0;

        if(isset($param['Estadoxnovedad']['trimestral']) && $param['Estadoxnovedad']['trimestral'] != '')
            $trimestral = $param['Estadoxnovedad']['trimestral'];
        else
            $trimestral = 0;

        $anioxtrim = Anioxtrimestral::find()
            ->where(['trimestral' => $trimestral])
            ->andWhere(['aniolectivo' => $aniolectivo])
            ->one();

        if($anioxtrim != null){
            $inicio =  $anioxtrim->inicio;
            $fin = $anioxtrim->fin;
        }else{
            $inicio =  0;
            $fin = 0;
        }
        
        if($estado == 1 || $estado == 2)
            $estado = [10,20];
        elseif($estado == 4)
            $estado = 40;
        elseif($estado == 5)
            $estado = 50;
        elseif($estado == 6)
            $estado = 30;

        if(isset($param['Estadoxnovedad']['preceptoria']) && $param['Estadoxnovedad']['preceptoria'] != '')
            $preceptoria = $param['Estadoxnovedad']['preceptoria'];
        else
            $preceptoria = 0;
        try {
            $pre = Preceptoria::findOne($preceptoria)->nombre;
        } catch (\Throwable $th) {
            $pre = 0;
        }

        if(in_array(Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_REGENCIA]) ){

            $query = Estadoxnovedad::find()
                    ->select(['estadoxnovedad.novedadesparte', 'estadoxnovedad.id as id, MAX(estadonovedad.orderstate) as estadonovedad'])
                    ->joinWith(['novedadesparte0', 'novedadesparte0.tiponovedad0', 'novedadesparte0.parte0', 'novedadesparte0.parte0.preceptoria0', 'estadonovedad0'])
                    ->where(['in', 'novedadesparte.tiponovedad', $tipodenovedadXusuario])
                    ->andWhere(['preceptoria.nombre' => $pre])
                    ->andWhere(['like', 'novedadesparte.descripcion', $descrip])
                    ->andWhere(['<=', 'parte.fecha', $fin])
                    ->andWhere(['>=', 'parte.fecha', $inicio])
                    ->having(['in', 'MAX(estadonovedad.orderstate)', $estado])
                    ->groupBy(['estadoxnovedad.novedadesparte'])
                    ->orderBy('parte.fecha');

        }

        else{
            if(in_array(Yii::$app->user->identity->role, [Globales::US_PRECEPTORIA, Globales::US_PRECEPTOR])){

                /*$role = Rolexuser::find()
                            ->where(['user' => Yii::$app->user->identity->id])
                            ->andWhere(['role' => Globales::US_PRECEPTORIA])
                            ->one();*/
                
                //$pre = Preceptoria::findOne($preceptoria);
                if(Yii::$app->user->identity->role == Globales::US_PRECEPTORIA){
                    $query = Estadoxnovedad::find()
                        ->select(['estadoxnovedad.novedadesparte', 'estadoxnovedad.id as id, MAX(estadonovedad.orderstate) as estadonovedad'])
                        ->joinWith(['novedadesparte0', 'novedadesparte0.tiponovedad0', 'novedadesparte0.parte0', 'novedadesparte0.parte0.preceptoria0', 'estadonovedad0'])
                        ->where(['in', 'novedadesparte.tiponovedad', $tipodenovedadXusuario])
                        ->andWhere(['preceptoria.nombre' => $pre])
                        ->andWhere(['like', 'novedadesparte.descripcion', $descrip])
                        ->andWhere(['<=', 'parte.fecha', $fin])
                        ->andWhere(['>=', 'parte.fecha', $inicio])
                        ->having(['in', 'MAX(estadonovedad.orderstate)', $estado])
                        ->groupBy(['estadoxnovedad.novedadesparte'])
                        ->orderBy('parte.fecha');
                }else{

                    $doc = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
                    $nom = Nombramiento::find()
                                ->where(['agente' => $doc->id])
                                ->andWhere(['<=', 'division', 53])
                                //->andWhere(['is not', 'division', 53])
                                ->all();
                    $query_parts = [];
                    foreach ($nom as $n) {

                        $query_parts[] = $n->division0->nombre;
                        
                    }
                    
                    //$string = implode(' OR novedadesparte.descripcion LIKE ', $query_parts);
                    
                    $query = Estadoxnovedad::find()
                        ->select(['estadoxnovedad.novedadesparte', 'estadoxnovedad.id as id, MAX(estadonovedad.orderstate) as estadonovedad'])
                        ->joinWith(['novedadesparte0', 'novedadesparte0.tiponovedad0', 'novedadesparte0.parte0', 'novedadesparte0.parte0.preceptoria0', 'estadonovedad0'])
                        ->where(['in', 'novedadesparte.tiponovedad', $tipodenovedadXusuario])
                        ->andWhere(['preceptoria.nombre' => $pre])
                        ->andWhere(['like', 'novedadesparte.descripcion', $descrip])
                        ->andWhere(['<=', 'parte.fecha', $fin])
                        ->andWhere(['>=', 'parte.fecha', $inicio])
                        ->andWhere(['or like', 'novedadesparte.descripcion', $query_parts])
                        ->having(['in', 'MAX(estadonovedad.orderstate)', $estado])
                        ->groupBy(['estadoxnovedad.novedadesparte'])
                        ->orderBy('parte.fecha');
                    /*$tipodenovedadXusuario = "(".implode(",", $tipodenovedadXusuario).")";
                    $estado = "(".implode(",", $estado).")";
                    
                    $sql = "SELECT parte.fecha, preceptoria.nombre, tiponovedad.nombre, novedadesparte.descripcion, estadoxnovedad.novedadesparte, estadoxnovedad.id as id, MAX(estadonovedad.orderstate) as estadonovedad 
                            FROM estadoxnovedad LEFT JOIN novedadesparte ON estadoxnovedad.novedadesparte = novedadesparte.id 
                            LEFT JOIN tiponovedad ON novedadesparte.tiponovedad = tiponovedad.id
                            LEFT JOIN parte ON novedadesparte.parte = parte.id 
                            LEFT JOIN preceptoria ON parte.preceptoria = preceptoria.id 
                            LEFT JOIN estadonovedad ON estadoxnovedad.estadonovedad = estadonovedad.id 
                            WHERE (novedadesparte.tiponovedad IN {$tipodenovedadXusuario}) 
                            AND (preceptoria.nombre = '{$pre}') 
                            AND (parte.fecha <= '{$fin}') 
                            AND (parte.fecha >= '{$inicio}') 
                            AND (novedadesparte.descripcion LIKE {$string}) 
                            GROUP BY estadoxnovedad.novedadesparte 
                            HAVING MAX(estadonovedad.orderstate) IN {$estado} 
                            ORDER BY parte.fecha";*/
                }
                
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

        // grid filtering conditions
        /*$query->andFilterWhere([
            'id' => $this->id,
            'estadonovedad' => $this->estadonovedad,
            //'parte' => $this->parte,
            
        ]);*/

        //$query->andFilterWhere(['like', 'descripcion', $this->descripcion]);
        //$query->andFilterWhere(['like', 'activo', $this->activo]);


        return $dataProvider;
    }
}
