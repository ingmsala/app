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
            [['id', 'docente', 'estadofonid'], 'integer'],
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
            'docente' => $this->docente,
            'fecha' => $this->fecha,
            'estadofonid' => $this->estadofonid,
        ]);

        return $dataProvider;
    }


    public function porAgente($params)
    {
        $persona = Docente::find()->where(['mail' => Yii::$app->user->identity->username])->one();
        if($persona == null){
            
                Yii::$app->session->setFlash('danger', 'Error de autentificación. Contacte al administrador del sistema');
                return $this->redirect(['index']); 
            
        }
        $query = Fonid::find()->where(['docente' => $persona->id])->orderBy('id desc');

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
            'docente' => $this->docente,
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
                        ->joinWith('docente0', 'RIGHT JOI')
                        ->where(['in', 'declaracionjurada.id', $subquery])
                        ->groupBy('person')
                        ->orderBy('declaracionjurada.id desc');*/
            if($pers == null){
                $sql = 'SELECT distinct docente.id, docente.documento, docente.apellido, docente.nombre, docente.mail from docente
                    WHERE docente.id in (select dc.docente from detallecatedra dc where dc.docente=docente.id and dc.activo=1) or 
                    docente.id in (select nom.docente from nombramiento nom where nom.docente=docente.id)
                    ORDER BY apellido, nombre';
            }else{
                $sql = 'SELECT id, documento, apellido, nombre, mail from docente
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
        
        $query = Fonid::find()->where(['docente' => $id])->orderBy('id desc');

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
