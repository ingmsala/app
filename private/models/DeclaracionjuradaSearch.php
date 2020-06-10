<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Declaracionjurada;
use yii\data\SqlDataProvider;

/**
 * DeclaracionjuradaSearch represents the model behind the search form of `app\models\Declaracionjurada`.
 */
class DeclaracionjuradaSearch extends Declaracionjurada
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'persona', 'estadodeclaracion', 'actividadnooficial', 'pasividad'], 'integer'],
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
    public function porAgente($params)
    {
        $persona = Docente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
        if($persona == null){
            $persona = Nodocente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
            if($persona == null){
                Yii::$app->session->setFlash('danger', 'Error de autentificación. Contacte al administrador del sistema');
                return $this->redirect(['index']); 
            }
        }
        $query = Declaracionjurada::find()->where(['persona' => $persona->documento])->orderBy('id desc');

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
            'persona' => $this->persona,
            'estadodeclaracion' => $this->estadodeclaracion,
            'fecha' => $this->fecha,
            'actividadnooficial' => $this->actividadnooficial,
            'pasividad' => $this->pasividad,
        ]);

        return $dataProvider;
    }

    public function porAgenteadmin($dni)
    {
        
        $query = Declaracionjurada::find()->where(['persona' => $dni])->orderBy('id desc');

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
        $query->andFilterWhere([
            'id' => $this->id,
            'persona' => $this->persona,
            'estadodeclaracion' => $this->estadodeclaracion,
            'fecha' => $this->fecha,
            'actividadnooficial' => $this->actividadnooficial,
            'pasividad' => $this->pasividad,
        ]);

        return $dataProvider;
    }

    public function porAnio($pers)
    {
        
           /* $subquery = (new \yii\db\Query)->select('max(id)')->from('declaracionjurada')->groupby('persona');
            $query = Declaracionjurada::find()
                        //->distinct()
                        ->joinWith('docente0', 'RIGHT JOI')
                        ->where(['in', 'declaracionjurada.id', $subquery])
                        ->groupBy('person')
                        ->orderBy('declaracionjurada.id desc');*/
            if($pers == null){
                $sql = 'SELECT * FROM (SELECT documento, apellido, nombre, mail from docente
                UNION DISTINCT
                SELECT documento, apellido, nombre, mail from nodocente) aa
                group by (documento)
                ORDER BY apellido, nombre';
            }else{
                $sql = 'SELECT * FROM (SELECT documento, apellido, nombre, mail from docente
                UNION DISTINCT
                SELECT documento, apellido, nombre, mail from nodocente) aa
                where documento = '.$pers.'
                group by (documento)
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
}
