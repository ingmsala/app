<?php
namespace app\components;

use yii\base\Widget;


class CardWidget extends Widget{
    public $ready;
    public $re;
    public $titulo;
    public $items;
    public $dataProvider;
    public $grid = null;
    public $color = null;
    public $columnas = [];
    public $columns = [];

    public function init(){
        //parent::init();
        $this->guessColumns();
        
        $models = $this->dataProvider->getModels();
        $keys = $this->dataProvider->getKeys();
        $obj = [];

        $model = [];

        $this->ready= '';

        if($this->grid == null){
            $this->grid = 12;
        }
        if($this->color == null){
            $this->color = 'default';
        }

        
        //$this->ready = $this->dataProvider->getTotalCount();
        foreach ($models as $key => $row) {
        
            $row2=[];
            foreach ($this->columns as $key2 => $value2) {
                $row2[$value2]=$row[$value2];
            }
            $model [$key] = $row2;
        }
        //$this->ready= var_dump($model);
        foreach ($model as $row3) {
    
        $cols = array_keys($row3);
        $colsparam = array_keys($this->columnas);


        $this->ready .= '<div class="col-md-'.$this->grid.'">';   
        $this->ready .= '<div class="panel panel-'.$this->color.'">
            
                <div class="panel-heading">'.$row3[$this->titulo[0]].', '.$row3[$this->titulo[1]].'</div>
                
            
                <ul class="list-group">';

                foreach ($row3 as $i => $value) {
                    //$this->re .= var_dump($row3); 
                    if(in_array($i,$colsparam))
                        $this->ready .= '<li class="list-group-item"><b>'.$this->columnas[$i].':</b> '.$value.'</li>';
                }
                    
                    
                $this->ready .= '</ul>';
                $this->ready .= '</div>';
                $this->ready .= '</div>';
            
        }
        //$models = array_values($this->dataProvider->getModels());
        //$this->ready = var_dump($models);

        
    }



    public function run(){
        return $this->ready;
        return var_dump($this->re);
    }

    protected function esColumna($valor){
        return in_array($valor, $this->columas);
    }

    protected function guessColumns()
    {
        $models = $this->dataProvider->getModels();
        $model = reset($models);
        if (is_array($model) || is_object($model)) {
            foreach ($model as $name => $value) {
                if ($value === null || is_scalar($value) || is_callable([$value, '__toString'])) {
                    $this->columns[] = (string) $name;
                }
            }
        }
    }
}
?>