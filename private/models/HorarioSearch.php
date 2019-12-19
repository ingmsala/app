<?php

namespace app\models;

use Yii;
use app\models\Horario;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;

/**
 * HorarioSearch represents the model behind the search form of `app\models\Horario`.
 */
class HorarioSearch extends Horario
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'catedra', 'hora', 'diasemana', 'tipo'], 'integer'],
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
    public function search($id)
    {
        $query = Horario::find()->where(['catedra' => $id]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($id);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'catedra' => $this->catedra,
            'hora' => $this->hora,
            'diasemana' => $this->diasemana,
            'tipo' => $this->tipo,
        ]);

        return $dataProvider;
    }

    public function horarioxdia($dia, $division)
    {
        $query = Horario::find()
            ->joinWith(['catedra0'])
            ->where(['diasemana' => $dia])
            ->andWhere(['catedra.division' => $division])
            ->andWhere(['tipo' => 1])
            ->orderBy('diasemana, hora');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

       // $this->load($dia, $curso);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'catedra' => $this->catedra,
            'hora' => $this->hora,
            'diasemana' => $this->diasemana,
            'tipo' => $this->tipo,
        ]);

        return $dataProvider;
    }   

    public function horassuperpuestas()
    {
       $sql='
            SELECT
                `docente`.`id`,
                `docente`.`apellido`,
                `docente`.`nombre`,
                `horario`.`diasemana`,
                `horario`.`hora`,
                `division`.`turno`
            FROM
                `horario`
            LEFT JOIN `catedra` ON `horario`.`catedra` = `catedra`.`id`
            LEFT JOIN `detallecatedra` ON `catedra`.`id` = `detallecatedra`.`catedra`
            LEFT JOIN `docente` ON `detallecatedra`.`docente` = `docente`.`id`
            LEFT JOIN `division` ON `catedra`.`division` = `division`.`id`
            WHERE
                `detallecatedra`.`revista` = 6
            GROUP BY
                `docente`.`id`,
                `docente`.`nombre`,
                `horario`.`diasemana`,
                `horario`.`hora`,
                `division`.`turno`
            HAVING
                COUNT(horario.id) > 1
            ORDER BY
                `docente`.`apellido`,
                `docente`.`nombre`';


        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
            'pagination' => false,
            
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }



        
        // grid filtering conditions
        

        return $dataProvider;
    }

    
}
