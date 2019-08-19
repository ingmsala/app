<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Notificacion;

/**
 * NotificacionSearch represents the model behind the search form of `app\models\Notificacion`.
 */
class NotificacionSearch extends Notificacion
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user', 'cantidad', 'tiponotificacion', 'estado'], 'integer'],
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
        $query = Notificacion::find();

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
            'user' => $this->user,
            'cantidad' => $this->cantidad,
            'tiponotificacion' => $this->tiponotificacion,
            'estado' => $this->estado,
        ]);

        return $dataProvider;
    }

    public static function providerXuser()
    {
        $model = Notificacion::find()
                    ->where(['user' => Yii::$app->user->identity->id])->one();

        return $model;
    }

    public static function providerXuserEspecifico($user)
    {
        $model = Notificacion::find()
                    ->where(['user' => $user])->one();

        return $model;
    }
}
