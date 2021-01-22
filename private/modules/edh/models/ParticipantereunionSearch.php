<?php

namespace app\modules\edh\models;

use app\models\Agente;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\edh\models\Participantereunion;

/**
 * ParticipantereunionSearch represents the model behind the search form of `app\modules\edh\models\Participantereunion`.
 */
class ParticipantereunionSearch extends Participantereunion
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'reunionedh', 'tipoparticipante', 'asistio', 'comunico', 'actividad'], 'integer'],
            [['participante'], 'safe'],
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
    public function porReunion($reunion)
    {
        $query = Participantereunion::find()->where(['reunionedh' => $reunion])->orderBy('tipoparticipante');

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
            'reunionedh' => $this->reunionedh,
            'tipoparticipante' => $this->tipoparticipante,
            'asistio' => $this->asistio,
            'comunico' => $this->comunico,
        ]);

        $query->andFilterWhere(['like', 'participante', $this->participante]);

        return $dataProvider;
    }

    public function participantes($reunion, $tipo=1)
    {
        $participantes = Participantereunion::find()->where(['reunionedh' => $reunion])->all();
        
        if($tipo == 1){
            $query = Agente::find()
            ->joinWith(['genero0', 'detallepartes'])
            ->where(['not in', 'documento', array_column($participantes, 'participante')])
            ->orderBy('apellido', 'nombre', 'legajo');
        }
        

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

        return $dataProvider;
    }


}
