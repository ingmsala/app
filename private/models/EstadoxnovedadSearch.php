<?php

namespace app\models;

use Yii;
use app\models\Anioxtrimestral;
use app\models\Estadoxnovedad;
use yii\base\Model;
use yii\data\ActiveDataProvider;

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
            
        $query = Estadoxnovedad::find()
                ->select(['estadoxnovedad.novedadesparte', 'estadoxnovedad.id as id, MAX(estadonovedad.orderstate) as estadonovedad'])
                ->joinWith(['novedadesparte0', 'novedadesparte0.tiponovedad0', 'novedadesparte0.parte0', 'novedadesparte0.parte0.preceptoria0', 'estadonovedad0'])
                ->where(['in', 'novedadesparte.tiponovedad', $tipodenovedadXusuario])
                ->andWhere(['preceptoria.nombre' => Yii::$app->user->identity->username])
                ->andWhere(['like', 'novedadesparte.descripcion', $descrip])
                ->andWhere(['<=', 'parte.fecha', $fin])
                ->andWhere(['>=', 'parte.fecha', $inicio])
                ->having(['in', 'MAX(estadonovedad.orderstate)', $estado])
                ->groupBy(['estadoxnovedad.novedadesparte'])
                ->orderBy('parte.fecha');
                                                
                            

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
            'estadonovedad' => $this->estadonovedad,
            //'parte' => $this->parte,
            
        ]);

        //$query->andFilterWhere(['like', 'descripcion', $this->descripcion]);
        //$query->andFilterWhere(['like', 'activo', $this->activo]);


        return $dataProvider;
    }
}
