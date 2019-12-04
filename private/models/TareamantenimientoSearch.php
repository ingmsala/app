<?php

namespace app\models;

use Yii;
use app\config\Globales;
use app\models\Nodocente;
use app\models\Tareamantenimiento;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * TareamantenimientoSearch represents the model behind the search form of `app\models\Tareamantenimiento`.
 */
class TareamantenimientoSearch extends Tareamantenimiento
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'responsable', 'estadotarea', 'novedadparte', 'prioridadtarea'], 'integer'],
            [['fecha', 'descripcion', 'fechafin'], 'safe'],
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
    public function activos($params)
    {
        if(in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_NOVEDADES]))
            $query = Tareamantenimiento::find()->where(['<>', 'estadotarea', 4])
                        ->orderBy('id DESC');
        else{
            $query = Tareamantenimiento::find()
                            ->where(['or',
                                ['is', 'responsable', null],
                                ['=', 'responsable', Nodocente::find()
                                                            ->where(['legajo' => Yii::$app->user->identity->username])
                                                            ->one()->id]])
                            ->andWhere(['<>', 'estadotarea', 4])
                            ->orderBy('id DESC');
        }

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
            'fecha' => $this->fecha,
            'responsable' => $this->responsable,
            'estadotarea' => $this->estadotarea,
            'novedadparte' => $this->novedadparte,
            'prioridadtarea' => $this->prioridadtarea,
            'fechafin' => $this->fechafin,
        ]);

        $query->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }

    public function realizados($params)
    {
        if(in_array (Yii::$app->user->identity->role, [Globales::US_SUPER, Globales::US_NOVEDADES]))
            $query = Tareamantenimiento::find()->where(['=', 'estadotarea', 4])->orderBy('id DESC');
        else{
            $query = Tareamantenimiento::find()
                            ->where(['or',
                                ['is', 'responsable', null],
                                ['=', 'responsable', Nodocente::find()
                                                            ->where(['legajo' => Yii::$app->user->identity->username])
                                                            ->one()->id]])
                            ->andWhere(['=', 'estadotarea', 4])
                            ->orderBy('id DESC');
        }

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
            'fecha' => $this->fecha,
            'responsable' => $this->responsable,
            'estadotarea' => $this->estadotarea,
            'novedadparte' => $this->novedadparte,
            'prioridadtarea' => $this->prioridadtarea,
            'fechafin' => $this->fechafin,
        ]);

        $query->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }
}
