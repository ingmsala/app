<?php

namespace app\models;

use Yii;
use app\models\Horario;
use app\modules\curriculares\models\Aniolectivo;
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
            [['id', 'catedra', 'hora', 'diasemana', 'tipo', 'tipomovilidad', 'aniolectivo'], 'integer'],
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

    public function horassuperpuestas($aniolectivo)
    {
       $sql='
            SELECT
                `agente`.`id`,
                `agente`.`apellido`,
                `agente`.`nombre`,
                `horario`.`diasemana`,
                `horario`.`hora`,
                `division`.`turno`
            FROM
                `horario`
            LEFT JOIN `catedra` ON `horario`.`catedra` = `catedra`.`id`
            LEFT JOIN `detallecatedra` ON `catedra`.`id` = `detallecatedra`.`catedra`
            LEFT JOIN `agente` ON `detallecatedra`.`agente` = `agente`.`id`
            LEFT JOIN `division` ON `catedra`.`division` = `division`.`id`
            WHERE
                `detallecatedra`.`revista` = 6 AND
                `detallecatedra`.`aniolectivo` = '.$aniolectivo.' AND
                `horario`.`aniolectivo` = '.$aniolectivo.' 
            GROUP BY
                `agente`.`id`,
                `agente`.`nombre`,
                `horario`.`diasemana`,
                `horario`.`hora`,
                `division`.`turno`
            HAVING
                COUNT(horario.id) > 1
            ORDER BY
                `agente`.`apellido`,
                `agente`.`nombre`';


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

    public function getDeshabilitados($aniolectivo)
    {
        //$aniolectivo = Aniolectivo::find()->where(['activo' => 1])->one();
        $query = Horario::find()
                    ->joinWith(['catedra0', 'catedra0.detallecatedras', 'catedra0.actividad0', 'catedra0.division0'])
                    ->where(['tipomovilidad' => 2])
                    ->andWhere(['tipo' => 1])
                    ->andWhere(['detallecatedra.revista' => 6])
                    ->andWhere(['horario.aniolectivo' => $aniolectivo])
                    ->andWhere(['detallecatedra.aniolectivo' => $aniolectivo])
                    ->orderBy('actividad.nombre, division.nombre, horario.diasemana, horario.hora');

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
            'catedra' => $this->catedra,
            'hora' => $this->hora,
            'diasemana' => $this->diasemana,
            'tipo' => $this->tipo,
        ]);

        return $dataProvider;
    }

    public function getCompletoDetallado($aniolectivo)
    {
        /*$query = Horario::find()
                    ->joinWith(['catedra0', 'catedra0.detallecatedras', 'catedra0.actividad0', 'catedra0.division0','catedra0.detallecatedras.agente0'])
                    ->andWhere(['tipo' => 1])
                    ->andWhere(['detallecatedra.revista' => 6])
                    ->orderBy('agente.apellido, agente.nombre, division.id')->distinct();*/

        //$aniolectivo = Aniolectivo::find()->where(['activo' => 1])->one();
        $query = Catedra::find()
        ->joinWith(['detallecatedras', 'actividad0', 'division0','detallecatedras.agente0', 'horarios'])
        ->andWhere(['horario.tipo' => 1])
        ->andWhere(['horario.aniolectivo' => $aniolectivo])
        ->andWhere(['detallecatedra.revista' => 6])
        ->andWhere(['detallecatedra.aniolectivo' => $aniolectivo])
        ->orderBy('agente.apellido, agente.nombre, division.id')->distinct();

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
            'catedra' => $this->catedra,
            'tipo' => $this->tipo,
        ]);

        return $dataProvider;
    }

    
}
