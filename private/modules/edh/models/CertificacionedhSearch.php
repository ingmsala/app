<?php

namespace app\modules\edh\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\edh\models\Certificacionedh;

/**
 * CertificacionedhSearch represents the model behind the search form of `app\modules\edh\models\Certificacionedh`.
 */
class CertificacionedhSearch extends Certificacionedh
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'solicitud', 'tipocertificado', 'tipoprofesional'], 'integer'],
            [['contacto', 'diagnostico', 'fecha', 'indicacion', 'institucion', 'referente', 'vencimiento'], 'safe'],
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
    public function porSolicitud($id)
    {
        $query = Certificacionedh::find()->where(['solicitud' => $id]);

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
            'fecha' => $this->fecha,
            'solicitud' => $this->solicitud,
            'tipocertificado' => $this->tipocertificado,
            'tipoprofesional' => $this->tipoprofesional,
        ]);

        $query->andFilterWhere(['like', 'contacto', $this->contacto])
            ->andFilterWhere(['like', 'diagnostico', $this->diagnostico])
            ->andFilterWhere(['like', 'indicacion', $this->indicacion])
            ->andFilterWhere(['like', 'institucion', $this->institucion])
            ->andFilterWhere(['like', 'referente', $this->referente]);

        return $dataProvider;
    }
}
