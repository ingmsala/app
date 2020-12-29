<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Fonid;
use yii\data\SqlDataProvider;

/**
 * FonidSearch represents the model behind the search form of `app\models\Fonid`.
 */
class FonidSearch extends Fonid
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'agente', 'estadofonid'], 'integer'],
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
        $query = Fonid::find();

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
            'fecha' => $this->fecha,
            'estadofonid' => $this->estadofonid,
        ]);

        return $dataProvider;
    }


    public function porAgente($params)
    {
        $persona = Agente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
        if($persona == null){
            
                Yii::$app->session->setFlash('danger', 'Error de autentificación. Contacte al administrador del sistema');
                return $this->redirect(['index']); 
            
        }
        $query = Fonid::find()->where(['agente' => $persona->id])->orderBy('id desc');

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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'agente' => $this->agente,
            'fecha' => $this->fecha,
            'estadofonid' => $this->estadofonid,
        ]);

        return $dataProvider;
    }

    public function porAnio($pers)
    {
        
           /* $subquery = (new \yii\db\Query)->select('max(id)')->from('declaracionjurada')->groupby('persona');
            $query = Declaracionjurada::find()
                        //->distinct()
                        ->joinWith('agente0', 'RIGHT JOI')
                        ->where(['in', 'declaracionjurada.id', $subquery])
                        ->groupBy('person')
                        ->orderBy('declaracionjurada.id desc');*/
            if($pers == null){
                $sql = 'SELECT distinct agente.id, agente.documento, agente.apellido, agente.nombre, agente.mail from agente
                    WHERE agente.id in (select dc.agente from detallecatedra dc where dc.agente=agente.id and dc.activo=1) or 
                    agente.id in (select nom.agente from nombramiento nom where nom.agente=agente.id)
                    ORDER BY apellido, nombre';
            }else{
                $sql = 'SELECT id, documento, apellido, nombre, mail from agente
                    where id = '.$pers.'
                    ORDER BY apellido, nombre';
            }
            
        

        
        
        

        // add conditions that should always apply here

        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
            'pagination' => false,
        ]);

        //$this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        

        return $dataProvider;
    }

    public function porAgenteadmin($id)
    {
        
        $query = Fonid::find()->where(['agente' => $id])->orderBy('id desc');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        //$this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        

        return $dataProvider;
    }
}
