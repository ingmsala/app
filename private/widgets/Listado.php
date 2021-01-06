<?php
namespace app\widgets;

use DateTime;
use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Alert widget renders a message from session flash. All flash messages are displayed
 * in the sequence they were assigned using setFlash. You can set message as following:
 *
 * ```php
 * Yii::$app->session->setFlash('error', 'This is the message');
 * Yii::$app->session->setFlash('success', 'This is the message');
 * Yii::$app->session->setFlash('info', 'This is the message');
 * ```
 *
 * Multiple messages could be set as follows:
 *
 * ```php
 * Yii::$app->session->setFlash('error', ['Error 1', 'Error 2']);
 * ```
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @author Alexander Makarov <sam@rmcreative.ru>
 */
class Listado extends Widget
{

    public $dataProvider;
    public $fecha;
    public $titulo;
    public $estado;
    public $contenido;
    public $pie;
    public $format;

    public function init()
    {
        parent::init();
        
        
    }

    public function run()
    {
        $echo = '';
        
        foreach ($this->dataProvider->getModels() as $dato) {

            
        $titulo = isset($dato[$this->titulo]) ? $dato[$this->titulo] : '';
        $estado = isset($dato[$this->estado]) ? $dato[$this->estado] : '';
        $fecha = isset($dato[$this->fecha]) ? $dato[$this->fecha] : '';
        $contenido = isset($dato[$this->contenido]) ? $dato[$this->contenido] : '';
        $pie = isset($dato[$this->pie]) ? $dato[$this->pie] : '';
        $format = isset($dato[$this->format]) ? $dato[$this->format] : null;

        /*if($this->validateDate($fecha, $this->format)){
            date_default_timezone_set('America/Argentina/Buenos_Aires');
            $fecha = Yii::$app->formatter->asDate($fecha, 'dd/MM/yyyy - hh:ii');
        }*/
        
        $contenido =    ArrayHelper::getValue($dato, $this->contenido);
        $estado =    ArrayHelper::getValue($dato, $this->estado);
        $fecha =    ArrayHelper::getValue($dato, $this->fecha);
        

        if(is_array($this->titulo)){
                //return var_dump($this->titulo);
                $titulo = $dato[$this->titulo[0]].$this->titulo[1].$dato[$this->titulo[2]];
        }
        if(is_array($this->fecha)){
                //return var_dump($this->fecha);
                $fecha = $dato[$this->fecha[0]].$this->fecha[1].$dato[$this->fecha[2]];
        }

                
        $echo .= '<div class="vista-listado flowGrid">
                    <div class="item-aviso flowGridItem">
                        <div class="header-aviso-resultados Empleos">
                            <h3>'.$titulo.'</h3>
                            <h4>'.$estado.'</h4>
                            <p class="fecha-publicado-resultados">'.$fecha.'</p>
                        </div>
                        <div class="content-aviso-resultados">
                        '.$contenido.'
                        </div>
                        <div class="footer-aviso-resultados">
                            <div class="box-rs">
                            '.$pie.'
                            </div>
                            <div class="box-btn-ver-mas">
                                <a href="#" class="btn btn-ver-mas">Ver mas</a>
                            </div>
                        </div>
                    </div>
                                    
                </div>';

        }



        return $echo;
    }

    private function concatenarArray($dato, $array)
    {
        if(is_array($array)){
            //return var_dump($this->titulo);
            return $dato[$array[0]].$array[1].$dato[$array[2]];
        }
        return $array;
    } 

    private function validateDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
        return $d && $d->format($format) === $date;
    }


}