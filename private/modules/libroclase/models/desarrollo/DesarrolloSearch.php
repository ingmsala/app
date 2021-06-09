<?php

namespace app\modules\libroclase\models\desarrollo;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\libroclase\models\desarrollo\Desarrollo;

/**
 * DesarrolloSearch represents the model behind the search form of `app\modules\libroclase\models\desarrollo\Desarrollo`.
 */
class DesarrolloSearch extends Desarrollo
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'aniolectivo', 'catedra', 'docente', 'estado'], 'integer'],
            [['fechacreacion', 'fechaenvio', 'motivo', 'token'], 'safe'],
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
    public function xcatedra($cat, $al)
    {
        $query = Desarrollo::find()->where(['catedra' => $cat, 'aniolectivo' => $al]);

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
            'aniolectivo' => $this->aniolectivo,
            'catedra' => $this->catedra,
            'docente' => $this->docente,
            'estado' => $this->estado,
            'fechacreacion' => $this->fechacreacion,
            'fechaenvio' => $this->fechaenvio,
        ]);

        $query->andFilterWhere(['like', 'motivo', $this->motivo]);

        return $dataProvider;
    }
}
